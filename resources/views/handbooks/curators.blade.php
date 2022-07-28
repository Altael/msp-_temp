@extends( request()->root() === env('AM_URL') ? 'layouts.am' : 'layouts.app' )

@section('body_class', request()->root() === env('AM_URL') ? 'amCurators' : 'appCurators')

@section('body_class', 'appCurators')

@section('content')

@endsection
