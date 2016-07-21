<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Comment;
use App\Http\Requests\CommentRequest;

class CommentsController extends Controller
{
    public function store(CommentRequest $request)
	{
		$comment = new Comment;
		$comment->commenter = $request->commenter;
		$comment->comment = $request->comment;
		$comment->post_id = $request->post_id;
		$comment->save();

		return back()->with('message', '投稿が完了しました');
	}
}
