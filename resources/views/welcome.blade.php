@extends('layouts.app')

@section('title', 'หน้าแรกของเว็บไซต์')

@section('content')
    <h2>บทความล่าสุด</h2>
    <hr>

    @forelse ($blogs as $item)
        <h2>{{ $item->title }}</h2>
        <p>{{ \Illuminate\Support\Str::limit(strip_tags($item->content), 100) }}</p>
        <a href="{{ route('blog.detail', $item->id) }}">อ่านเพิ่มเติม</a>
        <hr>
    @empty
        <p>ยังไม่มีบทความที่เผยแพร่</p>
    @endforelse
@endsection
