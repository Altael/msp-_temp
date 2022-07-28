@extends('layouts.app' )

@section('page')
    {{ __('Pure database requests') }}
@endsection
@section('body_class', 'appDBR')
@section('page_css')

@endsection

@section('content')
    {{ $data }}
@endsection
