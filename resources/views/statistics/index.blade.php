@extends('layouts.app')

@section('page', __('Statistics'))

@section('content')

    <statistics admin="{{ auth()->user()->hasRole('admin|acarya') ? true : false }}" statistics_viewer="{{ auth()->user()->hasRole('statistics_viewer') ? true : false }}"></statistics>

@endsection
