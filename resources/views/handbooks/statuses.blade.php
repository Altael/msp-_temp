@extends( request()->root() === env('AM_URL') ? 'layouts.am' : 'layouts.app' )

@section('body_class', request()->root() === env('AM_URL') ? 'amStatuses' : 'appStatuses')

@section('page')
    {{ __('Unit users statuses') }}
@endsection

@section('content')
    <statuses></statuses>
@endsection
