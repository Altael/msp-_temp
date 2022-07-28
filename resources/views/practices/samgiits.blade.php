@extends( request()->root() === env('AM_URL') ? 'layouts.am' : 'layouts.app' )

@section('page_css')
    <link href="{{ mix('css/am/samgiits.css') }}" rel="stylesheet">
@endsection

@section('body_class', request()->root() === env('AM_URL') ? 'amSamgiits toolbarNone' : 'appSamgiits')

@section('page')
    {{ __('Prabhat Samgiits') }}
@endsection

@section('content')
    <page-title title="Prabhat Samgiits" link="/news"></page-title>
    <prabhat-samgiits ps="{{ request('ps') }}" ml="{{ request('ml') }}" tl="{{ request('tl') }}"></prabhat-samgiits>
@endsection
