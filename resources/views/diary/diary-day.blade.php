@extends('layouts.am')

@section('page', __('Sadhana diary') . " | ")

@section('body_class', 'amDiary')

@section('page_css')
    <link href="{{ mix('css/am/diary.css') }}" rel="stylesheet">
@endsection


@section('content')
    <diary-am
        locale="{{ app()->getLocale() }}"
        :man="{{ auth()->user()->profile->sex == 'male' ? 'true' : 'false' }}"
    ></diary-am>
@endsection


