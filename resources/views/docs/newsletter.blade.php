@extends( request()->root() === env('AM_URL') ? 'layouts.am' : 'layouts.app' )

@section('page', __('Newsletter consent'))
@section('body_class', 'appDocs appDocs-newsletter')

@section('page_css')
    @if(request()->root() === env('AM_URL') )
        <link href="{{ mix('css/am/docs.css') }}" rel="stylesheet">
    @endif
@endsection

@section('content')
    @if(request()->root() === env('AM_URL') )
        <a href="javascript:history.go(-1)" class="amPage-title">{{__('Back')}}</a>
    @endif
    @if($lang == 'ru')
        @include('docs/newsletter_ru')
    @else
        @include('docs/newsletter_en')
    @endif

@endsection
