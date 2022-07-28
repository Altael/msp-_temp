@extends( request()->root() === env('AM_URL') ? 'layouts.am' : (auth()->user()->sadvipra ? 'layouts.sadvipra' : 'layouts.app') )

@section('page', __('Profile'))

@section('help')
    <info id="appProfile-mainHelp" v-cloak :with-text="false" :with-video="true" title="How to register">
        <div class="iframeResponsive">
            <iframe src="https://drive.google.com/file/d/1-10UgDHeW4oE2aQoGKE5xLrae1mvqu5f/preview"></iframe>
        </div>
    </info>

@endsection

@section('body_class', request()->root() === env('AM_URL') ? 'amProfilePage' : 'appProfilePage')


@section('page_css')
    @if(request()->root() === env('AM_URL'))
        <link href="{{ mix('css/am/profile.css') }}" rel="stylesheet">
    @endif
@endsection

@section('content')
    @if( request()->root() === env('AM_URL') )
        <user-profile-am :admin="{{ auth()->user()->hasRole('admin') ? 'true' : 'false' }}" :bp="{{ auth()->user()->hasRole('bp') ? 'true' : 'false' }}" :secretary="{{ auth()->user()->hasRole('secretary') ? 'true' : 'false' }}"></user-profile-am>
    @else
        <user-profile app="{{ request()->root() === env('AM_URL') ? "am" : "app" }}" lang="{{ app()->getLocale() }}"></user-profile>
    @endif
@endsection

@section('page_js')
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://maps.google.com/maps/api/js?v=3.exp&key={{ env('GOOGLE_MAP_KEY') }}&libraries=places&language=ru"></script>
@append
