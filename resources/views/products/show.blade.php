<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} の詳細・編集 - もぎたて</title>
    <style>
        body {
            background-color: #f8f8f8;
            font-family: 'Helvetica Neue', Arial, sans-serif;
            color: #333333;
            margin: 0;
            padding: 0;
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

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .breadcrumb {
            font-size: 14px;
            margin-bottom: 20px;
            color: #666666;
        }

        .breadcrumb a {
            color: #007bff;
            text-decoration: none;
        }

        .edit-layout {
            display: flex;
            gap: 30px;
            margin-bottom: 20px;
        }

        .image-section {
            flex: 1;
        }

        .product-image {
            width: 100%;
            height: 260px;
            object-fit: cover;
            border-radius: 6px;
            background-color: #eeeeee;
            margin-bottom: 12px;
        }

        .form-section {
            flex: 1;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label.title {
            display: block;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 6px;
        }

        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
            background-color: #ffffff;
        }

        .season-group {
            display: flex;
            gap: 16px;
            align-items: center;
            padding-top: 4px;
        }

        .season-group label {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 14px;
            cursor: pointer;
        }

        .error-message {
            color: #ef4444;
            font-size: 13px;
            margin-top: 6px;
            margin-bottom: 0;
        }

        .description-section {
            margin-bottom: 30px;
        }

        .button-area {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            position: relative;
        }

        .btn-back {
            background-color: #e0e0e0;
            color: #333333;
            padding: 12px 50px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
        }

        .btn-submit {
            background-color: #f5c800;
            color: #333333;
            padding: 12px 45px;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            font-size: 14px;
            cursor: pointer;
        }

        .delete-form {
            display: flex;
            justify-content: flex-end;
            margin-top: -36px;
        }

        .btn-delete {
            background: none;
            border: none;
            color: #ef4444;
            font-size: 22px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <header class="header">
        <a href="/products" class="header-logo">mogitate</a>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="/products">商品一覧</a> ＞ {{ $product->name }}
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