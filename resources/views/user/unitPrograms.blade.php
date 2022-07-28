@extends( request()->root() === env('AM_URL') ? 'layouts.am' : 'layouts.app' )

@section('page_css')
    <link href="{{ mix('css/am/unit.css') }}" rel="stylesheet">
@endsection

@section('page')
    {{ __('Unit programs') }}
@endsection

@section('body_class', request()->root() === env('AM_URL') ? 'amUnitEvents' : 'appUnitEvents')


@section('content')
    <unit-programs :secretary="{{auth()->user()->hasRole('secretary') ? 'true' : 'false'}}" :programmer="{{auth()->user()->hasRole('programmer') ? 'true' : 'false'}}"></unit-programs>
@endsection
