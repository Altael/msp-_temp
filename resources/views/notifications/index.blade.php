@extends('layouts.app')

@section('page', __('Notifications'))

@section('content')

    <notifications type="{{ request('type') }}" item="{{ request('item') }}"></notifications>

@endsection
