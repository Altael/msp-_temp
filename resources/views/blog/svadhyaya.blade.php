@extends('layouts.am')

@section('page', __('Svadhyaya') . " | ")

@section('body_class', 'appSvadhyaya')

@section('page_css')
    <link href="{{ mix('css/am/svadhyaya_page.css') }}" rel="stylesheet">
@endsection

@section('content')
    <svadhyaya :show_interface="true"></svadhyaya>
@endsection
