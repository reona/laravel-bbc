# Laravel 5.1 で作成する掲示板

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

Laravelフレームワークで掲示板を作成します

- [Laravel 公式ドキュメント（英語）](https://laravel.com/docs/5.2)
- [Laravel 日本語ドキュメント](http://readouble.com/laravel/)

掲示板作成に使用した参考サイト

- [Laravelで掲示板を作成する方法](http://manablog.org/laravel_bulletin_board/)

> あらかじめ、laravel コマンドで新規Laravelプロジェクトが作成できることが前提になります
> できない場合は、まず composer のインストールから行ってください

## step1. laravel コマンドで新規プロジェクトを作ろう

コマンドプロンプトで下記コマンドを実行します

```
laravel new bbc
```

新規プロジェクトを作ると、必ず最初に `composer install` が実行され依存関係のライブラリがインストールされます

## step2. マイグレーション（migration）ファイルを作成しよう

データベースにテーブルを作成するにはマイグレーションファイルを使用します

> 参考サイト : 

今回掲示板を作るためには以下のテーブルが必要です

- ポストテーブル(posts) : 作成した投稿データを格納するテーブル
- カテゴリーテーブル(categories) : 作成したカテゴリーデータを格納するテーブル
- コメントテーブル(comments) : 作成したコメントデータを格納するテーブル

早速作っていきましょう、以下のコマンドをコマンドプロンプトで実行してみてください

マイグレーションファイルを作成するには、`artisan` コマンドを使用します

````
php artisan make:migration create_posts_table --create=posts
````

```
php artisan make:migration create_categories_table --create=categories
```

```
php artisan make:migration create_comments_table --create=comments
```

> Laravelの規約に従うために、データベース名は必ず複数形にします

## step3. マイグレーションで作成されたファイルにカラムの情報を書き込む

- 編集するファイル : app/database/migrations/~_create_posts_table.php

> ~ の部分は作成した日付、時間が入るので作成者によって変わります

エディタで開くと下記のようになっているかと思います

```
# 省略
class CreatePostsTable extends Migration {
    public function up()
    {
        Schema::create('posts', function($table){
            $table->increments('id');
            $table->timestamps();
        });
    }
}
```

下記のように変更してください

```
# 省略
class CreatePostsTable extends Migration {
    public function up()
    {
        Schema::create('posts', function($table){
            $table->increments('id');
            # ここから
            $table->string('title'); // 投稿のタイトルが格納されます
            $table->string('cat_id'); // カテゴリーのIDが格納されます
            $table->text('content'); // 投稿の内容が格納されます
            $table->unsignedInteger('comment_count'); // 投稿のコメント数が格納されます
            # ここまで
            $table->timestamps();
        });
    }
}
```

次にカテゴリーのマイグレーションファイルを編集します

- 編集するファイル : app/database/migrations/~_create_categories_table.php

> ~ の部分は作成した日付、時間が入るので作成者によって変わります

エディタで開くと下記のようになっているかと思います

```
# 省略
class CreateCategoriesTable extends Migration {
    public function up()
    {
        Schema::create('categories', function($table){
            $table->increments('id');
            $table->timestamps();
        });
    }
}
```

下記のように変更してください

```
# 省略
class CreateCategoriesTable extends Migration {
    public function up()
    {
        Schema::create('categories', function($table){
            $table->increments('id');
            # ここから
            $table->string('name'); // カテゴリーの名前が格納されます
            # ここまで
            $table->timestamps();
        });
    }
}
```

次にコメントのマイグレーションファイルを編集します

- 編集するファイル : app/database/migrations/~_create_comments_table.php

> ~ の部分は作成した日付、時間が入るので作成者によって変わります

エディタで開くと下記のようになっているかと思います

```
# 省略
class CreateCommentsTable extends Migration {
    public function up()
    {
        Schema::create('comments', function($table){
            $table->increments('id');
            $table->timestamps();
        });
    }
}
```

下記のように変更してください

```
# 省略
class CreateCommentsTable extends Migration {
    public function up()
    {
        Schema::create('comments', function($table){
            $table->increments('id');
            # ここから
            $table->unsignedInteger('post_id'); // 投稿のIDが格納されます
            $table->string('commenter'); // コメント投稿者の名前が格納されます
            $table->text('comment'); // コメントが格納されます
            # ここまで
            $table->timestamps();
        });
    }
}
```

こちらでマイグレーションファイルを修正し終わりました

次に .env ファイルをエディタで開き、データベース接続情報を編集します

- 編集するファイル : .env

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bbc // データベースの名前をbbcにします
DB_USERNAME=root // 接続ユーザ、パスワードは各自の環境によって異なります
DB_PASSWORD=
```

最後に `artisan migrate` コマンドを実行します

```
php artisan migrate
```

> 参考サイト : 

## step4. モデルファイルを作成します

下記コマンドをコマンドプロンプトで実行してモデルファイルを作成します

```
php artisan make:model Post
```

```
php artisan make:model Category
```

```
php artisan make:model Comment
```

モデルファイルは、`app` フォルダ以下に作成されます

## step5. モデルのリレーションを設定する

データベースには、各テーブルにリレーションという関係性があるものがあります

今回の場合、

- 投稿はたくさんのコメントが書き込まれます（1対多の関係）
- 投稿は一つのカテゴリーに所属します（1対1の関係）

モデルにもリレーション関係を記述します

- 編集するファイル : `app/models/Post.php`

```
class Post extends Eloquent {

    // ここから
    public function comments() {
        // 投稿はたくさんのコメントを持つ
        return $this->hasMany('App\Comment', 'post_id');
    }
    
    public function category() {
        // 投稿は1つのカテゴリーに属する
        return $this->belongsTo('App\Category', 'cat_id');
    }
    // ここまで
}
```

## step6. 投稿のコントローラーを生成する

Laravel 中級チュートリアルでもありましたが、コントローラーを作成しその中でHttpに関係する処理を記述していきます

どういうことだと思われるかと思いますが、下記コマンドをコマンドプロンプトで実行します

```
php artisan make:controller PostsController
```

すると、`app/Http/Controllers/` に新しく `PostsController` ファイルが作成されたかと思います

次に下記のようにルーティングを設定します。

- 編集するファイル : `aap/routes.php`

```
Route::get('/', function () {
    return view('welcome');
});

# ここから下を追記します
Route::resource('bbc', 'PostsController');
```

この時点でコマンドプロンプトで下記コマンドを実行してみてください

```
php artisan route:list
```


## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
