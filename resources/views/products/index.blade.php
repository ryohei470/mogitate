<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品一覧 - もぎたてフルーツショップ</title>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
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