@extends('layouts.app')

@section('page', __('My initiations'))

@section('content')
    <initiation-list :per-page="10"></initiation-list>
@endsection
