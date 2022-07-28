@extends('layouts.app')

@section('page')
    {{ __('Admin Panel') }}
@endsection
@section('content')
    <settings-panel entity="msp"></settings-panel>
@endsection
