@extends( request()->root() === env('AM_URL') ? 'layouts.am' : 'layouts.app' )

@section('page_css')
    <link href="{{ mix('css/am/dharmacakra.css') }}" rel="stylesheet">
@endsection

@section('body_class', request()->root() === env('AM_URL') ? 'amDharmacakra toolbarNone' : 'appDharmacakra')

@section('page')
    {{ __('Dharmacakra') }}
@endsection

@section('content')
    <page-title title="Dharmacakra" link="/news"></page-title>
    <dharmacakra ps="{{ request('ps') }}" ml="{{ request('ml') }}" tl="{{ request('tl') }}"></dharmacakra>
@endsection
