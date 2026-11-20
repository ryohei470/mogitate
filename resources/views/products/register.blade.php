<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>商品登録 - もぎたて</title>
    　
    <link rel="stylesheet" href="{{ asset('css/register.css') }}" />
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
                <input type="text" name="name" value="{{ old('name') }}" placeholder="商品名を入力" />
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
                <input type="number" name="price" value="{{ old('price') }}" placeholder="値段を入力" />
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
                    <img id="previewImage" src="" alt="プレビュー" />
                </div>
                <input type="file" name="image" id="imageInput" accept=".png,.jpeg,.jpg" />
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
                            <input
                                type="checkbox"
                                name="seasons[]"
                                value="{{ $season->id }}"
                                {{ is_array(old('seasons')) && in_array($season->id, old('seasons')) ? 'checked' : '' }}
                            />
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
        document.getElementById('imageInput').addEventListener('change', function (event) {
            const file = event.target.files[0];
            const previewBox = document.getElementById('previewBox');
            const previewImage = document.getElementById('previewImage');

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
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
