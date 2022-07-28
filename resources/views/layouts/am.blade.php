<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    data-registered="{{ auth()->check() ? auth()->user()->registration_completed : false }}"
    data-am="{{ request()->root() === env('AM_URL') }}"
    data-link="{{ explode('/', request()->path())[0] }}"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="minimal-ui = 1, width=device-width, initial-scale=1, user-scalable=no">
    <!-- Allows fullscreen mode from the Homescreen -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <!-- Sets the color of the text/battery, wireless icons etc -->
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('page') Ananda Marga
    </title>

    <!-- Scripts -->
    <script>window._translations = {!! cache('translations-' . App::getLocale()) !!};</script>

    @if(env('NODE_ENV') !== 'development')
        @laravelPWA
    @endif

@yield('page_js')

<!-- Styles -->
    {{--<link href="https://fonts.googleapis.com/css?family=Rubik&display=swap" rel="stylesheet">--}}
    <link href="/css/animate.css" rel="stylesheet">

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
    <link href="/css/iframe.css" rel="stylesheet">
    <link href="/css/constructor.css" rel="stylesheet">
    <link href="/css/close.css" rel="stylesheet">
    <link href="/css/btn.css" rel="stylesheet">
    <link href="/css/iframe.css" rel="stylesheet">
    <link href="{{ mix('css/am.css') }}" rel="stylesheet">

    @yield('page_css')

    <link rel="apple-touch-icon" sizes="180x180" href="/favicons/am/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicons/am/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicons/am/favicon-16x16.png">
    <link rel="mask-icon" href="/favicons/am/safari-pinned-tab.svg" color="#ff6600">
    <link rel="shortcut icon" href="/favicons/am/favicon.ico">

    <!-- Respond.js для IE8 (media queries) -->
    <!-- ПРЕДУПРЕЖДЕНИЕ: Respond.js не будет работать при просмотре страницы через file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body class="appAMLayout {{ auth()->check() ? "appAuthorized" : "appAuthorizedNot" }} {{ (request()->root() === env('AM_URL')) ? "theme_am" : "theme_msp" }} {{ explode('/', request()->path())[0] }} @yield('body_class')">
<div id="app" :class="{'amDiaryEditing': diaryEdit}">
    <alerts></alerts>
    <!--
     ____    _    ____    _       _   _    _    __  __    _  _________     ___    _        _    __  __
    | __ )  / \  | __ )  / \     | \ | |  / \  |  \/  |  | |/ / ____\ \   / / \  | |      / \  |  \/  |
    |  _ \ / _ \ |  _ \ / _ \    |  \| | / _ \ | |\/| |  | ' /|  _|  \ \ / / _ \ | |     / _ \ | |\/| |
    | |_) / ___ \| |_) / ___ \   | |\  |/ ___ \| |  | |  | . \| |___  \ V / ___ \| |___ / ___ \| |  | |
    |____/_/   \_\____/_/   \_\  |_| \_/_/   \_\_|  |_|  |_|\_\_____|  \_/_/   \_\_____/_/   \_\_|  |_|
    -->
    <div class="app">
        <div class="appPageContent">
            <div class="appPageContentBody dhrtScroll-wrapperOuter">
                <div class="dhrtScroll-wrapperInner">
                    @yield('content')
                </div>
            </div>

        </div>
        @if(auth()->check())
        <div class="amToolbar">
            <div class="amToolbar-items">
                <a href="/news" class="amToolbar-item {{ Str::startsWith( request()->path(), 'news') ? 'active' : '' }}">
                    <div class="appIcons msppIcons-news"></div>
                    <div class="amToolbar-itemText">{{ __('News') }}</div>
                </a>
                <a href="/education" class="amToolbar-item {{ Str::startsWith( request()->path(), 'education') ? 'active' : '' }}">
                    <div class="appIcons msppIcons-learn"></div>
                    <div class="amToolbar-itemText">{{ __('Learn') }}</div>
                </a>
                <a href="/diary-day" class="amToolbar-item {{ Str::startsWith( request()->path(), 'diary-record') || Str::startsWith( request()->path(), 'diary-day') ? 'active' : '' }} {{ auth()->user() && auth()->user()->registration_completed ? '' : 'disabled' }}">
                    <div class="appIcons msppIcons-add-circle"></div>
                    <div class="amToolbar-itemText">{{ __('Diary') }}</div>
                </a>

                <a href="/practices" class="amToolbar-item {{ Str::startsWith( request()->path(), ['practice', 'category/', 'post/']) ? 'active' : 'practice' }}">
                    <div class="appIcons msppIcons-practices"></div>
                    <div class="amToolbar-itemText">{{ __('Practices') }}</div>
                </a>
                <a href="/profile" class="amToolbar-item {{ Str::startsWith( request()->path(), ['profile', 'fastings', 'unit', 'user/conversations', 'user/missing-lessons', 'user/request', 'user/lessons']) ? 'active' : 'profile' }}">
                    <div class="appIcons msppIcons-profile"></div>
                    <div class="amToolbar-itemText">{{ __('Profile') }}</div>
                </a>
            </div>
        </div>
        @endif

        <scroll-to-top></scroll-to-top>
    </div>
    @if(auth()->check() && auth()->user()->hasPermission('cheatWithRoles'))
        <roles-cheat :id="{{ auth()->user()->id }}"></roles-cheat>
    @endif

    <div class="appWaitAnimateLoader" v-if="loading">
        <div class="dhrtWaitAnimateLoader">
            <div class="dhrtWaitAnimateLoader-inner dhrtWaitAnimateLoader-one"></div>
            <div class="dhrtWaitAnimateLoader-inner dhrtWaitAnimateLoader-two"></div>
            <div class="dhrtWaitAnimateLoader-inner dhrtWaitAnimateLoader-three"></div>
        </div>
    </div>
</div>
<script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>

<script type="text/javascript">
    /*dhrtDropdown.init();*/
</script>
<script>
    $('[title]').tooltip();
</script>
@extends('layouts.swipeHandler')
</body>
</html>
