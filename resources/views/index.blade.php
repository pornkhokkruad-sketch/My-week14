@extends('layouts.app')

@section('title', 'หน้าแรกของเว็บไซต์')

@section('content')
    <h2>บทความล่าสุด</h2>
    <hr>
    @foreach ($blogs as $item)
        <h2>{{$item->title}}</h2>
        <p>{{$item->detail}}</p>
        <a href="#">อ่านเพิ่มเติม</a>
        <hr>
    @endforeach
@endsection
