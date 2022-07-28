@extends('layouts.app')

@section('page', __('All users'))

@section('body_class', 'appUserList')

@section('content')
    <user-list :curator="{{ auth()->user()->hasRole('curator') ? 'true' : 'false' }}" :admin="{{ auth()->user()->hasRole('admin|dean') ? 'true' : 'false' }}" :acarya="{{ auth()->user()->hasRole('acarya') ? 'true' : 'false' }}" :trustee="{{ auth()->user()->hasRole('trustee') ? 'true' : 'false' }}" :bp="{{ auth()->user()->hasRole('bp') ? 'true' : 'false' }}" :secretary="{{ auth()->user()->hasRole('secretary') ? 'true' : 'false' }}" user-id="{{ request('user') ?? null }}" :per-page="100"></user-list>
@endsection
