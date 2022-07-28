@extends('layouts.app')

@section('page', __('Events Report'))

@section('body_class', 'eventsReportPage')

@section('content')
    <events-report entity="unit" :master="{{ auth()->user()->hasRole('admin|bc|acb|vmtr') ? 'true' : 'false' }}" :bp="{{ auth()->user()->hasRole('bp') ? 'true' : 'false' }}"></events-report>
@endsection
