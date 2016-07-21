@extends('layouts.default')
@section('content')

    <div class="col-xs-8 col-xs-offset-2">

        @foreach($posts as $post)

            <h2>タイトル：{{ $post->title }}
                <small>投稿日：{{ date("Y年 m月 d日",strtotime($post->created_at)) }}</small>
            </h2>
            <p>カテゴリー : {{ link_to("/category/{$post->category->id}", $post->category->name, array('class' => '')) }}</p>
            <p>{{ $post->content }}</p>
            <p>{{ link_to("/bbc/{$post->id}", '続きを読む', array('class' => 'btn btn-primary')) }}</p>
            <p>コメント数：{{ $post->comment_count }}</p>
            <hr />
        @endforeach

    </div>

@endsection