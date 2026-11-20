<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} の詳細・編集 - もぎたて</title>
　　<link rel="stylesheet" href="{{ asset('css/show.css') }}">
</head>

<body>
    <header class="header">
        <a href="/products" class="header-logo">mogitate</a>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="/products">商品一覧</a> > {{ $product->name }}
        </div>

        <!-- 更新フォーム（PG03） -->
        <form action="/products/{{ $product->id }}/update" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="edit-layout">
                <!-- 左側：商品画像とファイル選択 -->
                <div class="image-section">
                    <img id="previewImage" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
                    <input type="file" name="image" id="imageInput" accept=".png,.jpeg,.jpg">
                    @error('image')
                    <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 右側：商品名・値段・季節 -->
                <div class="form-section">
                    <div class="form-group">
                        <label class="title">商品名</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}">
                        @error('name')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="title">値段</label>
                        <input type="number" name="price" value="{{ old('price', $product->price) }}">
                        @error('price')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="title">季節</label>
                        <div class="season-group">
                            @foreach ($seasons as $season)
                            <label>
                                <input type="checkbox" name="seasons[]" value="{{ $season->id }}"
                                    {{ $product->seasons->contains($season->id) ? 'checked' : '' }}>
                                {{ $season->name }}
                            </label>
                            @endforeach
                        </div>
                        @error('seasons')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- 下部：商品説明 -->
            <div class="form-group description-section">
                <label class="title">商品説明</label>
                <textarea name="description" rows="5">{{ old('description', $product->description) }}</textarea>
                @error('description')
                <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- 戻る・変更を保存ボタン -->
            <div class="button-area">
                <a href="/products" class="btn-back">戻る</a>
                <button type="submit" class="btn-submit">変更を保存</button>
            </div>
        </form>

        <!-- 削除ボタン（PG06） -->
        <form action="/products/{{ $product->id }}/delete" method="POST" class="delete-form" onsubmit="return confirm('本当にこの商品を削除しますか？');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-delete" title="削除">🗑️</button>
        </form>
    </div>

    <!-- 新しい画像を選択したときに即座にプレビューを切り替えるスクリプト -->
    <script>
        document.getElementById('imageInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const previewImage = document.getElementById('previewImage');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>

</html>