@extends('layouts.am')

@section('page', __('News') . " | ")

@section('body_class', 'appNews')

@section('page_css')


    <link href="{{ mix('css/am/blog.css') }}" rel="stylesheet">
@endsection

@section('content')
    <news post="{{ request('post') }}"></news>
@endsection
