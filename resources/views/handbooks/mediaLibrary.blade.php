@extends('layouts.app')

@section('page')
    {{ __('Media files library') }}
@endsection
@section('content')
    <media-lib root="{{ request()->root() }}"></media-lib>
@endsection
