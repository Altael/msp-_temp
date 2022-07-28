@extends( request()->root() === env('AM_URL') ? 'layouts.am' : 'layouts.app' )

@section('page_css')
    <link href="{{ mix('css/am/practices.css') }}" rel="stylesheet">
@endsection

@section('body_class', request()->root() === env('AM_URL') ? 'amCategories' : 'appPractices')

@section('page')
    {{ __('Practices') }}
@endsection

@section('content')
    <category-listing category="practices"></category-listing>
@endsection
