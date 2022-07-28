@extends( request()->root() === env('AM_URL') ? 'layouts.am' : 'layouts.app' )

@section('page_css')
    <link href="{{ mix('css/am/unit.css') }}" rel="stylesheet">
@endsection

@section('body_class', request()->root() === env('AM_URL') ? 'amPrograms' : 'appPrograms')

@section('page')
    {{ __('Unit programs editor') }}
@endsection

@section('content')
    <programs></programs>
@endsection
