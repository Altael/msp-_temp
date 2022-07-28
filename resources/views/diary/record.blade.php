@extends('layouts.am')

@section('page', __('Diary record') . " | ")

@section('body_class', 'amDiary')

@section('page_css')
    <link href="{{ mix('css/am/diary_record.css') }}" rel="stylesheet">
@endsection


@section('content')
    <diary-record
        locale="{{ app()->getLocale() }}"
        :man="{{ auth()->user()->profile->sex == 'male' ? 'true' : 'false' }}"
    ></diary-record>
@endsection


