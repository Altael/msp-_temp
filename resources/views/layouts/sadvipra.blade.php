<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    data-registered="{{ auth()->check() ? auth()->user()->registration_completed : false }}"
    data-am="{{ request()->root() === env('AM_URL') }}"
    data-link="{{ explode('/', request()->path())[0] }}"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @if(request()->root() === env('AM_URL'))
            Ananda Marga
        @else
            MSPersonal
        @endif
    </title>

    <!-- Scripts -->
    <script>window._translations = {!! cache('translations-' . App::getLocale()) !!};</script>

    <!--PWA-->
    @if(env('NODE_ENV') !== 'development')
        @laravelPWA
    @endif


@yield('page_js')

    <link href="/css/animate.css" rel="stylesheet">

<!-- Styles -->
    {{--<link href="https://fonts.googleapis.com/css?family=Rubik&display=swap" rel="stylesheet">--}}
    <link href="/css/dropdown.css" rel="stylesheet">
    <link href="/fonts/mspp-icons-v1.0/style.css" rel="stylesheet">
    <link href="/css/effects.css" rel="stylesheet">
    <link href="/css/toasted.css" rel="stylesheet">
    <link href="/css/radio.css" rel="stylesheet">
    <link href="/css/checkbox.css" rel="stylesheet">
    <link href="/css/scroll.css" rel="stylesheet">
    <link href="/css/search.css" rel="stylesheet">
    <link href="/css/modalWindow.css" rel="stylesheet">
    <link href="/css/switch.css" rel="stylesheet">
    <link href="/css/waitAnimate.css" rel="stylesheet">
    <link href="/css/close.css" rel="stylesheet">
    <link href="/css/btn.css" rel="stylesheet">
    <link href="/css/constructor.css" rel="stylesheet">
    <link href="/css/iframe.css" rel="stylesheet">
    @if(request()->root() === env('AM_URL'))
        <link href="{{ mix('css/am.css') }}" rel="stylesheet">
    @else
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @endif

    @if(auth()->user()->sadvipra)
        <link href="{{ mix('css/sadvipra.css') }}" rel="stylesheet">
    @endif


    @yield('page_css')


    @if(request()->root() === env('AM_URL'))
        <link rel="apple-touch-icon" sizes="180x180" href="/favicons/am/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicons/am/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicons/am/favicon-16x16.png">
        <link rel="manifest" href="/favicons/am/site.webmanifest">
        <link rel="mask-icon" href="/favicons/am/safari-pinned-tab.svg" color="#5bbad5">
        <link rel="shortcut icon" href="/favicons/am/favicon.ico">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="msapplication-config" content="/favicons/am/browserconfig.xml">
        <meta name="theme-color" content="#ffffff">
    @else
        <link rel="apple-touch-icon" sizes="180x180" href="/favicons/msp/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicons/msp/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicons/msp/favicon-16x16.png">
        <link rel="manifest" href="/favicons/msp/site.webmanifest">
        <link rel="mask-icon" href="/favicons/msp/safari-pinned-tab.svg" color="#ff6600">
        <link rel="shortcut icon" href="/favicons/msp/favicon.ico">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="msapplication-TileImage" content="/favicons/msp/mstile-144x144.png">
        <meta name="msapplication-config" content="/favicons/msp/browserconfig.xml">
        <meta name="theme-color" content="#ffffff">
    @endif

</head>
<body class="sadvipraLayout {{ auth()->check() ? "appAuthorized" : "appAuthorizedNot" }} {{ (request()->root() === env('AM_URL')) ? "theme_am" : "theme_msp" }} @yield('body_class')">
<div id="app">
    <alerts></alerts>
    <!--
     ____    _    ____    _       _   _    _    __  __    _  _________     ___    _        _    __  __
    | __ )  / \  | __ )  / \     | \ | |  / \  |  \/  |  | |/ / ____\ \   / / \  | |      / \  |  \/  |
    |  _ \ / _ \ |  _ \ / _ \    |  \| | / _ \ | |\/| |  | ' /|  _|  \ \ / / _ \ | |     / _ \ | |\/| |
    | |_) / ___ \| |_) / ___ \   | |\  |/ ___ \| |  | |  | . \| |___  \ V / ___ \| |___ / ___ \| |  | |
    |____/_/   \_\____/_/   \_\  |_| \_/_/   \_\_|  |_|  |_|\_\_____|  \_/_/   \_\_____/_/   \_\_|  |_|
    -->
    <div class="sadvipra">
        {{--@auth--}}
        <input type="checkbox" id="appMobileMenu-chk">

        <div class="appBrandMenu effectScale noScroll">

            <div class="appBrand">
                @if (auth()->check())
                    <label class="appMobileMenu-wrapper" for="appMobileMenu-chk">
                        <span class="appMobileMenu-icon">
                            <span class="appMobileMenu-bar1"></span>
                            <span class="appMobileMenu-bar2"></span>
                            <span class="appMobileMenu-bar3"></span>
                        </span>
                    </label>
                @endif
                <a class="appBrand-link" href="/">
                    <span class="appBrand-content">
                        <span class="appLogoMain">
                            @include('layouts/logo')
                        </span>
                        <span class="appName">
                            @if(request()->root() === env('AM_URL'))
                                <!-- am -->
                                <span class="appNameAM">ananda</span><span class="appNameAM">marga</span>
                                <span class="appNameValue">{{ __('self-realization') }}</span><span class="appNameValue">{{ __('service to all') }}</span>
                            @else
                                <!-- msp -->
                                <span>Meditationsteps</span>
                                <span>Personal</span>
                            @endif
                        </span>
                    </span>
                </a>
            </div>

            @if (auth()->check() && auth()->user()->isRegistrationCompleted())
                <user-info class="effectScale-target" :user-id="{{ auth()->id() }}" :data='@json(session('user'))'></user-info>
            @endif

            @include('layouts/menu')


        </div>
        <div class="appContent">
            <div class="appPageHeader">
                <h2>
                    @yield('page')
                </h2>
                @if (auth()->check() && auth()->user()->isRegistrationCompleted())
                    <app-header-tools></app-header-tools>
                @endif
            </div>
            <div class="appPageContent">
<!--
                <div class="dhrtScroll-wrapperOuter">
                    <div class="dhrtScroll-wrapperInner" ref="pageScroller">
-->
                        @yield('content')
{{--
                    </div>
                </div>
--}}
            </div>
            <support-menu-item v-if="showSupport"></support-menu-item>
            @if(auth()->check() && auth()->user()->hasPermission('cheatWithRoles'))
                <roles-cheat :id="{{ auth()->user()->id }}"></roles-cheat>
            @endif

        </div>
        {{--@endauth--}}

    </div>
    @if(!auth()->check())
        <div class="appPageLogin-support">
            <a href="/support" @click.prevent="showSupport = 1" class="appPageLogin-supportLink">
                <span class="appMenu-itemIcon appIcons msppIcons-help-circle"></span>
                <span class="appMenu-itemText">{{ __('Support') }}</span>
            </a>
        </div>
    @endif
    <!--tools-->

    <div class="appWaitAnimateLoader" v-if="loading">
        <div class="dhrtWaitAnimateLoader">
            <div class="dhrtWaitAnimateLoader-inner dhrtWaitAnimateLoader-one"></div>
            <div class="dhrtWaitAnimateLoader-inner dhrtWaitAnimateLoader-two"></div>
            <div class="dhrtWaitAnimateLoader-inner dhrtWaitAnimateLoader-three"></div>
        </div>
    </div>
    <confirm-pop-up-shell ref="confirm_popup_shell"></confirm-pop-up-shell>
    <!--endtools-->

</div>
<script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>


<script>
    $('[title]').tooltip();
</script>
@extends('layouts.swipeHandler')
</body>
</html>
