@extends('layouts.app')

@section('page', __('Questions'))
@section('body_class', 'appPageQuestions')

@section('content')
    <conversations dialogue-id="{{ request('dialogue') ?? null }}"></conversations>
@endsection
