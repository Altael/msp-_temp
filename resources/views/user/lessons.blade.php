@extends( request()->root() === env('AM_URL') ? 'layouts.am' : 'layouts.app' )


@section('page', __('My lessons'))

@section('body_class', request()->root() === env('AM_URL') ? 'amProfilePage appUserLessons' : 'appUserLessons')

@section('page_css')
    @if(request()->root() === env('AM_URL') )
        <link href="{{ mix('css/am/profile.css') }}" rel="stylesheet">
    @endif
@endsection

@section('content')

    <user-lessons :user-id="{{ auth()->id() }}"></user-lessons>

@endsection
