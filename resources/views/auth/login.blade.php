@extends((request()->root() === env('AM_URL')) ? "layouts.am" : "layouts.app")

@section('body_class', 'appPageLogin')

@section('content')
    <div class="appLogin-bg"></div>
    <div class="appLogin-bg-animation"></div>

    <div class="appLogin-wrap">
        <div class="appWelcomeScreen-name">
            {{ request()->root() === env('AM_URL')  ? "Anandamarga.me" : "Meditationsteps.Personal" }}
        </div>
        <social-authorize></social-authorize>
    </div>
@endsection
