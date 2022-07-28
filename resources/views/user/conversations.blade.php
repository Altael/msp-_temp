@extends( request()->root() === env('AM_URL') ? 'layouts.am' : 'layouts.app' )


@section('page_css')
    @if(request()->root() === env('AM_URL'))
        <link href="{{ mix('css/am/conversation.css') }}" rel="stylesheet">
        <link href="{{ mix('css/am/profile.css') }}" rel="stylesheet">
    @endif
@endsection


@section('page', __('Conversations'))

@section('body_class', request()->root() === env('AM_URL') ? 'amPageUserConversation amProfilePage' : 'appPageUserConversations')

@section('content')

    <user-conversations dialogue-id="{{request('dialogue') ?? null}}"></user-conversations>

@endsection
