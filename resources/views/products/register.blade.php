<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品登録 - もぎたて</title>
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
            max-width: 680px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .page-title {
            font-size: 26px;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .label-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }

        .form-label {
            font-size: 14px;
            font-weight: bold;
        }

        .required-badge {
            background-color: #ef4444;
            color: #ffffff;
            font-size: 11px;
            font-weight: bold;
            padding: 2px 6px;
            border-radius: 2px;
        }

        .sub-note {
            color: #ef4444;
            font-size: 12px;
        }

        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
            background-color: #ffffff;
        }

        .image-preview-box {
            margin-bottom: 12px;
            display: none;
        }

        .image-preview-box img {
            max-width: 320px;
            max-height: 220px;
            border-radius: 4px;
            border: 1px solid #d1d5db;
            object-fit: cover;
        }

        .season-list {
            display: flex;
            gap: 24px;
            padding-top: 4px;
        }

        .season-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 14px;
            cursor: pointer;
        }

        .error-message {
            color: #ef4444;
            font-size: 13px;
            margin-top: 6px;
            margin-bottom: 0;
        }

        .button-group {
            display: flex;
            justify-content: center;
            gap: 24px;
            margin-top: 40px;
        }

        .btn-back {
            background-color: #e0e0e0;
            color: #333333;
            padding: 12px 60px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
        }

        .btn-submit {
            background-color: #f5c800;
            color: #333333;
            padding: 12px 60px;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            font-size: 14px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <header class="header">
        <a href="/products" class="header-logo">mogitate</a>
    </header>

    <div class="container">
        <h1 class="page-title">商品登録</h1>

        <form action="/products/register" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- 商品名 -->
            <div class="form-group">
                <div class="label-row">
                    <label class="form-label">商品名</label>
                    <span class="required-badge">必須</span>
                </div>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="商品名を入力">
                @error('name')
                <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- 値段 -->
            <div class="form-group">
                <div class="label-row">
                    <label class="form-label">値段</label>
                    <span class="required-badge">必須</span>
                </div>
                <input type="number" name="price" value="{{ old('price') }}" placeholder="値段を入力">
                @error('price')
                <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- 商品画像 -->
            <div class="form-group">
                <div class="label-row">
                    <label class="form-label">商品画像</label>
                    <span class="required-badge">必須</span>
                </div>
                <div class="image-preview-box" id="previewBox">
                    <img id="previewImage" src="" alt="プレビュー">
                </div>
                <input type="file" name="image" id="imageInput" accept=".png,.jpeg,.jpg">
                @error('image')
                <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- 季節 -->
            <div class="form-group">
                <div class="label-row">
                    <label class="form-label">季節</label>
                    <span class="required-badge">必須</span>
                    <span class="sub-note">複数選択可</span>
                </div>
                <div class="season-list">
                    @foreach ($seasons as $season)
                    <label class="season-item">
                        <input type="checkbox" name="seasons[]" value="{{ $season->id }}"
                            {{ is_array(old('seasons')) && in_array($season->id, old('seasons')) ? 'checked' : '' }}>
                        {{ $season->name }}
                    </label>
                    @endforeach
                </div>
                @error('seasons')
                <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- 商品説明 -->
            <div class="form-group">
                <div class="label-row">
                    <label class="form-label">商品説明</label>
                    <span class="required-badge">必須</span>
                </div>
                <textarea name="description" rows="5" placeholder="商品の説明を入力">{{ old('description') }}</textarea>
                @error('description')
                <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- ボタン -->
            <div class="button-group">
                <a href="/products" class="btn-back">戻る</a>
                <button type="submit" class="btn-submit">登録</button>
            </div>
        </form>
    </div>

    <!-- 画像選択時にプレビューを表示するスクリプト -->
    <script>
        document.getElementById('imageInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const previewBox = document.getElementById('previewBox');
            const previewImage = document.getElementById('previewImage');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewBox.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                previewBox.style.display = 'none';
                previewImage.src = '';
            }
        });
    </script>
</body>

</html>