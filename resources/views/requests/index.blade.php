@extends('layouts.app')

@section('page', __('Requests'))

@section('content')
    <request-list :per-page="50" id="{{ request('id') ?? null }}"></request-list>
@endsection
