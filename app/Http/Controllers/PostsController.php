<?php

namespace App\Http\Controllers;

use App\Post;
use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;


class PostsController extends Controller
{
    // 投稿一覧を表示するメソッド
	public function index()
	{
		// Posts テーブルから全データ取得
		$posts = Post::all();

		return view('bbc.index', [
			'posts' => $posts,
		]);
	}

	// 投稿の詳細ページを表示するメソッド
	public function show($id)
	{
		// 投稿IDから投稿情報を取得
		// SQL文にすると、 SELECT * from posts WHERE id = $id みたいな
		$post = Post::find($id);

		// bbcフォルダのsingle.blade.php ファイルに 取得してきた $post 変数を渡している
		return view('bbc.single', [
			'post' => $post,
		]);
	}

	// 投稿作成ページを表示するメソッド
	public function create()
	{
		return view('bbc.create');
	}

	/**
	 * 投稿を保存するメソッド
	 *
	 * @param PostRequest $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(PostRequest $request)
	{
		$post = new Post;
		$post->title  = $request->title;
		$post->content = $request->content;
		$post->cat_id = $request->cat_id;
		$post->save();

		return back()->with('message', '投稿が完了しました');
	}

	/**
	 * カテゴリーに所属する記事一覧を表示するメソッド
	 *
	 * @param $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function showCategory($id)
	{
		$category_posts = Post::where('cat_id', $id)->get();

		return view('category.index', [
			'category_posts' => $category_posts,
		]);
	}


}
