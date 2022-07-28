@extends( request()->root() === env('AM_URL') ? 'layouts.am' : 'layouts.app' )

@section('body_class', request()->root() === env('AM_URL') ? 'amRoles' : 'appRoles')

@section('page')
    {{ __('MSP roles') }}
@endsection

@section('content')
    <roles></roles>
@endsection
