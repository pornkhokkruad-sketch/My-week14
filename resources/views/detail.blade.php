@extends('layouts.app')

@section('title', $blog->title)

@section('content')
    <style>
        .article-content iframe {
            display: block;
            max-width: 100%;
            margin: 1rem 0;
            border: 0;
        }
    </style>

    <article class="container py-5">
        <h1>{{ $blog->title }}</h1>
        <hr>
        <div class="article-content">
            {!! $blog->content !!}
        </div>
        <a href="{{ route('blog') }}">กลับไปหน้าบทความ</a>
    </article>
@endsection
