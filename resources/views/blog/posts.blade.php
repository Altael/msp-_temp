@extends('layouts.app')

@section('page')
    {{ $title }}
@endsection
@section('content')
    <posts category="{{ $category }}"></posts>
@endsection
