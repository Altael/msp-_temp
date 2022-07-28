@extends( 'layouts.sadvipra' )

@section('page', __('Curator call requests list'))

@section('page_css')
    <link href="{{ mix('css/sadvipra/callRequests.css') }}" rel="stylesheet">
@endsection

@section('body_class','sadvipraCallRequests')


@section('content')
    <call-requests :user_id="{{ auth()->user()->id }}"></call-requests>
@endsection
