@extends( request()->root() === env('AM_URL') ? 'layouts.am' : 'layouts.app' )

@section('page', __('Missing lessons'))

@section('body_class', request()->root() === env('AM_URL') ? 'amMissingLessons' : 'appMissingLessons')

@section('page_css')
    @if(request()->root() === env('AM_URL') )
        <link href="{{ mix('css/am/missing_lessons.css') }}" rel="stylesheet">
        <link href="{{ mix('css/am/profile.css') }}" rel="stylesheet">
    @endif
@endsection

@section('content')

    @if( request()->root() === env('AM_URL') )
        <user-missing-lessons-am></user-missing-lessons-am>
    @else
        <user-missing-lessons :user-id="{{ auth()->id() }}"></user-missing-lessons>
    @endif
@endsection
