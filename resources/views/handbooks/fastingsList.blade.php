@extends( request()->root() === env('AM_URL') ? 'layouts.am' : 'layouts.app' )

@section('page')
    {{ __('Fastings list') }}
@endsection

@section('body_class', request()->root() === env('AM_URL') ? 'amProfilePage amFasting' : 'appFasting')

@section('page_css')
    @if(request()->root() === env('AM_URL') )
        <link href="{{ mix('css/am/fastings_list.css') }}" rel="stylesheet">
        <link href="{{ mix('css/am/profile.css') }}" rel="stylesheet">
    @endif

@endsection

@section('content')
    @if( request()->root() === env('AM_URL') )
        <fastings-list-am lang="{{ app()->getLocale() }}"></fastings-list-am>
    @else
        <fastings-list></fastings-list>
    @endif
@endsection
