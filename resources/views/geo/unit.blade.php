@extends('layouts.am')

@section('page', __('My unit'))

@section('body_class', request()->root() === env('AM_URL') ? 'amUnit' : 'appUnit')


@section('page_css')
    @if(request()->root() === env('AM_URL') )
        <link href="{{ mix('css/am/unit.css') }}" rel="stylesheet">
        <link href="{{ mix('css/am/profile.css') }}" rel="stylesheet">
    @endif
@endsection

@section('content')
    <unit :secretary="{{auth()->user()->hasRole('secretary') ? 'true' : 'false'}}" :programmer="{{auth()->user()->hasRole('programmer') ? 'true' : 'false'}}"></unit>
@endsection
