# もぎたて（mogitate）

## アプリケーション概要

野菜・果物のECサイト「もぎたて」の商品管理アプリケーションです。
商品の閲覧、キーワード・価格帯検索、価格順並び替え、新規登録、編集・更新、削除ができます。

## 環境構築

1. リポジトリのクローン
   `git clone https://github.com`
2. Dockerビルド
   `./vendor/bin/sail up -d`
3. パッケージのインストール・マイグレーション・シーディング
   `./vendor/bin/sail composer install`
   `./vendor/bin/sail artisan key:generate`
   `./vendor/bin/sail artisan migrate:fresh --seed`
   `./vendor/bin/sail artisan storage:link`

## 使用技術（実行環境）

- PHP 8.x
- Laravel 11.x / 12.x
- MySQL 8.0
- Docker（Laravel Sail）

## URL

- 商品一覧画面：http://localhost/products
- 商品登録画面：http://localhost/products/register

## ER図

（ここに後ほどER図の画像を添付します）
