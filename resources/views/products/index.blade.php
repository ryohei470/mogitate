<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品一覧 - もぎたてフルーツショップ</title>
    <style>
        body {
            background-color: #f8f8f8;
            font-family: 'Helvetica Neue', Arial, sans-serif;
            color: #111827;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        .header {
            background-color: #ffffff;
            padding: 16px 32px;
            border-bottom: 1px solid #eeeeee;
        }

        .header-logo {
            color: #f5c800;
            font-size: 24px;
            font-weight: bold;
            font-style: italic;
            text-decoration: none;
        }

        .main-container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .page-title {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }

        .add-btn {
            background-color: #f59e0b;
            color: #111827;
            padding: 10px 18px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
        }

        .shop-layout {
            display: flex;
            gap: 40px;
        }

        .search-sidebar {
            flex: 1;
            min-width: 240px;
            max-width: 240px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: bold;
            color: #4b5563;
            margin-bottom: 6px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 8px 10px;
            font-size: 14px;
            box-sizing: border-box;
            background-color: #ffffff;
        }

        .search-btn {
            width: 100%;
            background-color: #fcd34d;
            color: #111827;
            font-weight: bold;
            padding: 10px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            margin-top: 10px;
        }

        .sort-tag {
            margin-top: 16px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1px solid #f59e0b;
            border-radius: 20px;
            padding: 4px 12px;
            font-size: 13px;
            background-color: #fffbeb;
        }

        .sort-tag a {
            color: #f59e0b;
            text-decoration: none;
            font-weight: bold;
        }

        .product-main {
            flex: 3;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .product-card {
            text-decoration: none;
            color: inherit;
            display: block;
            background-color: #ffffff;
            border-radius: 8px;
            padding-bottom: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .image-placeholder {
            background-color: #f3f4f6;
            height: 160px;
            margin-bottom: 10px;
            overflow: hidden;
        }

        .product-info {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            padding: 0 12px;
        }

        .product-name {
            font-size: 15px;
            font-weight: bold;
            margin: 0;
        }

        .product-price {
            font-size: 15px;
            font-weight: bold;
            margin: 0;
        }

        /* ページネーションのデザイン */
        .pagination-wrap {
            margin-top: 36px;
            display: flex;
            justify-content: center;
        }

        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
            gap: 8px;
        }

        .page-item .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background-color: #ffffff;
            color: #333333;
            text-decoration: none;
            font-size: 14px;
            border: 1px solid #e5e7eb;
        }

        .page-item.active .page-link {
            background-color: #f5c800;
            color: #ffffff;
            font-weight: bold;
            border-color: #f5c800;
        }

        .page-item.disabled .page-link {
            color: #9ca3af;
            pointer-events: none;
        }
    </style>
</head>

<body>
    <header class="header">
        <a href="/products" class="header-logo">mogitate</a>
    </header>

    <div class="main-container">
        <div class="top-bar">
            <h1 class="page-title">
                @if (request()->filled('keyword'))
                “{{ request('keyword') }}”の商品一覧
                @else
                商品一覧
                @endif
            </h1>
            <a href="/products/register" class="add-btn">＋ 商品を追加</a>
        </div>

        <div class="shop-layout">
            <!-- 左側：検索・並び替えエリア -->
            <div class="search-sidebar">
                <form action="/products/search" method="GET">
                    <div class="form-group">
                        <label>商品名キーワード</label>
                        <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="商品名で検索">
                    </div>

                    <div class="form-group">
                        <label>最低料金（円）</label>
                        <input type="number" name="min_price" value="{{ request('min_price') }}">
                    </div>

                    <div class="form-group">
                        <label>最高料金（円）</label>
                        <input type="number" name="max_price" value="{{ request('max_price') }}">
                    </div>

                    <div class="form-group">
                        <label>価格順で表示</label>
                        <select name="sort">
                            <option value="">価格で並べ替え</option>
                            <option value="high" {{ request('sort') === 'high' ? 'selected' : '' }}>高い順に表示</option>
                            <option value="low" {{ request('sort') === 'low' ? 'selected' : '' }}>低い順に表示</option>
                        </select>
                    </div>

                    <button type="submit" class="search-btn">検索</button>
                </form>

                <!-- 並び替え中のタグ表示 -->
                @if (request('sort') === 'high' || request('sort') === 'low')
                <div class="sort-tag">
                    <span>{{ request('sort') === 'high' ? '高い順に表示' : '低い順に表示' }}</span>
                    <a href="{{ request()->fullUrlWithQuery(['sort' => null]) }}">×</a>
                </div>
                @endif
            </div>

            <!-- 右側：商品一覧とページネーション -->
            <div class="product-main">
                <div class="product-grid">
                    @foreach ($products as $product)
                    <a href="/products/detail/{{ $product->id }}" class="product-card">
                        <div class="image-placeholder">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div class="product-info">
                            <h3 class="product-name">{{ $product->name }}</h3>
                            <p class="product-price">¥{{ $product->price }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>

                <!-- ページ送りボタン -->
                <div class="pagination-wrap">
                    {{ $products->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</body>

</html>