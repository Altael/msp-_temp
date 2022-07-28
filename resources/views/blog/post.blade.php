@extends( request()->root() === env('AM_URL') ? 'layouts.am' : 'layouts.app' )

@section('page')
    {{ $title }}
@endsection

@section('page_css')
    <link href="{{ mix('css/am/practices.css') }}" rel="stylesheet">
@endsection

@section('content')
    <post post_slug="{{ $post_slug }}" category="{{ $category }}"></post>
@endsection
