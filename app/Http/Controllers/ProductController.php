<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Season;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // 1. 商品一覧・検索・並び替え画面（ページネーション対応）
    public function index(Request $request)
    {
        $query = Product::with('seasons');

        // 商品名キーワード検索
        if ($request->filled('keyword')) {
            $query->where('name', 'LIKE', '%' . $request->keyword . '%');
        }

        // 最低料金・最高料金の検索
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // 価格の並び替え（高い順・低い順）
        if ($request->input('sort') === 'high') {
            $query->orderBy('price', 'desc');
        } elseif ($request->input('sort') === 'low') {
            $query->orderBy('price', 'asc');
        }

        // 1ページ6件ずつ表示（検索・並び替え条件を次のページへ引き継ぐ）
        $products = $query->paginate(6)->withQueryString();

        return view('products.index', compact('products'));
    }

    // 2. 新規商品登録画面の表示
    public function create()
    {
        $seasons = Season::all();
        return view('products.register', compact('seasons'));
    }

    // 3. 新規商品の保存処理
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|integer|min:0|max:10000',
            'image' => 'required|mimes:png,jpeg',
            'seasons' => 'required',
            'description' => 'required|max:120',
        ], [
            'name.required' => '商品名を入力してください',
            'price.required' => '値段を入力してください',
            'price.integer' => '数値で入力してください',
            'price.min' => '0~10000円以内で入力してください',
            'price.max' => '0~10000円以内で入力してください',
            'image.required' => '商品画像を登録してください',
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
            'seasons.required' => '季節を選択してください',
            'description.required' => '商品説明を入力してください',
            'description.max' => '120文字以内で入力してください',
        ]);

        $imagePath = $request->file('image')->store('', 'public');

        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'image' => $imagePath,
            'description' => $request->description,
        ]);

        $product->seasons()->attach($request->seasons);

        return redirect('/products');
    }

    // 4. 商品詳細・編集画面
    public function show($productId)
    {
        $product = Product::with('seasons')->findOrFail($productId);
        $seasons = Season::all();

        return view('products.show', compact('product', 'seasons'));
    }

    // 5. 商品更新処理（バリデーション追加済み）
    public function update(Request $request, $productId)
    {
        // 更新時は画像を新しく選び直さなくても良いように 'nullable' にする
        $request->validate([
            'name' => 'required',
            'price' => 'required|integer|min:0|max:10000',
            'image' => 'nullable|mimes:png,jpeg',
            'seasons' => 'required',
            'description' => 'required|max:120',
        ], [
            'name.required' => '商品名を入力してください',
            'price.required' => '値段を入力してください',
            'price.integer' => '数値で入力してください',
            'price.min' => '0~10000円以内で入力してください',
            'price.max' => '0~10000円以内で入力してください',
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
            'seasons.required' => '季節を選択してください',
            'description.required' => '商品説明を入力してください',
            'description.max' => '120文字以内で入力してください',
        ]);

        $product = Product::findOrFail($productId);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('', 'public');
            $product->image = $imagePath;
        }

        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->save();

        $product->seasons()->sync($request->input('seasons', []));

        return redirect('/products');
    }

    // 6. 商品削除処理
    public function destroy($productId)
    {
        $product = Product::findOrFail($productId);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect('/products');
    }
}
