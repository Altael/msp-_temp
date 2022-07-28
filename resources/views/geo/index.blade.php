@extends('layouts.app')

@section('page', __('GEO regions'))

@section('content')
    <geo :admin="{{ auth()->user()->hasRole('admin') ? 'true' : 'false' }}" :menu="{{ auth()->user()->hasRole('admin|geo-editor|bc') ? 'true' : 'false' }}" :districts_cheater="{{ auth()->user()->hasRole('all_districts') ? 'true' : 'false' }}" :bp="{{ auth()->user()->hasRole('bp') ? 'true' : 'false' }}"></geo>
@endsection

@section('page_js')
    <script src="https://maps.google.com/maps/api/js?v=3.exp&key={{ env('GOOGLE_MAP_KEY') }}&libraries=places&language=en"></script>
@append
