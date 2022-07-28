@extends('layouts.app')

@section('page')
    {{ __('Prabhat Samgiits editor') }}
@endsection
@section('content')
    <samgiits-editor samgiit="{{ request('samgiit') }}"></samgiits-editor>
@endsection
