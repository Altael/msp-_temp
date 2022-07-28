@extends('layouts.app')

@section('page', __('Diary'))

@section('body_class', 'appPageDiary')


@section('content')
    <diary
        :man="{{ auth()->user()->profile->sex == 'male' ? 'true' : 'false' }}"
        new="{{ request('new', 'false') }}"
        user-id="{{ request('user') ?? auth()->id() }}"
        app="{{ request()->root() === env('AM_URL') ? "am" : "app" }}"
    ></diary>
@endsection


