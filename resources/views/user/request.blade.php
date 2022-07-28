@extends( request()->root() === env('AM_URL') ? 'layouts.am' : (auth()->user()->sadvipra ? 'layouts.sadvipra' : 'layouts.app') )

@section('page', __('Getting or checking lessons'))

@section('body_class', request()->root() === env('AM_URL') ? 'amProfilePage' : 'appRequests')


@section('page_css')
    @if(request()->root() === env('AM_URL'))
        <link href="{{ mix('css/am/request.css') }}" rel="stylesheet">
        <link href="{{ mix('css/am/profile.css') }}" rel="stylesheet">
    @endif
@endsection

@section('content')

    <user-request am="{{ request()->root() === env('AM_URL') }}" :user-id="{{ auth()->id() }}" locale="{{ app()->getLocale() }}" sex="{{ auth()->user()->profile->sex }}"></user-request>

@endsection
