@extends( 'layouts.sadvipra' )

@section('page_css')
    <link href="{{ mix('css/sadvipra/medForEve.css') }}" rel="stylesheet">
@endsection

@section('body_class','sadvipraCallRequest')


@section('content')
    <get-lesson></get-lesson>
@endsection
