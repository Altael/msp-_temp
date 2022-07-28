@extends( request()->root() === env('AM_URL') ? 'layouts.am' : 'layouts.app' )

@section('page')
    {{ __($title) }}
@endsection

@section('page_css')
    <link href="{{ mix('css/am/practices.css') }}" rel="stylesheet">
@endsection

@section('body_class', request()->root() === env('AM_URL') ? 'amCategory ' . $category_slug : 'appCategory ' . $category_slug)

@section('content')
    <category-listing category="{{ $category_slug }}"></category-listing>
@endsection
