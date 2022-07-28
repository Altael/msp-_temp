@extends('layouts.app')


@section('page')
    {{ __('Welcome') . ', ' . auth()->user()->profile->private_name }}
@endsection

@section('content')
    {{--@if (session('status'))
        <div class="mb-5 alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif--}}

    <div class="appHome">
        @if (auth()->check() && auth()->user()->isRegistrationCompleted())

            @if (!auth()->user()->hasRole('acarya'))

                <a href="/user/request" class="appMenu-item {{ Str::startsWith( request()->path(), 'user/request') ? 'active' : '' }}">
                    <span class="appMenu-itemIcon appIcons msppIcons-feather"></span>
                    <span class="appMenu-itemText">{{ __('Requests') }}</span>
                </a>
                @if(auth()->user()->currentLesson)
                    <a href="/user/lessons" class="appMenu-item {{ Str::startsWith( request()->path(), 'user/lessons') ? 'active' : '' }}">
                        <span class="appMenu-itemIcon appIcons msppIcons-edit-3"></span>
                        <span class="appMenu-itemText">{{ __('Lessons') }}</span>
                    </a>
                    <a href="/user/conversations" class="appMenu-item {{ Str::startsWith( request()->path(), 'user/conversations') ? 'active' : '' }}">
                        <span class="appMenu-itemIcon appIcons msppIcons-edit"></span>
                        <span class="appMenu-itemText">{{ __('Conversations') }}</span>
                        <questions-unread-badge></questions-unread-badge>
                    </a>
                @endif

            @endif
            <a href="/diary"
               class="appMenu-item {{ Str::endsWith( request()->path(), 'diary') ? 'active' : '' }}">
                <span class="appMenu-itemIcon appIcons msppIcons-book"></span>
                <span class="appMenu-itemText">{{ __('Diary') }}</span>
            </a>
            @if (auth()->user()->hasRole('diary'))
                <a href="/diary-edit"
                   class="appMenu-item {{ Str::endsWith( request()->path(), 'diary-edit') ? 'active' : '' }}">
                    <span class="appMenu-itemIcon appIcons msppIcons-book"></span>
                    <span class="appMenu-itemText">{{ __('Diaries settings') }}</span>
                </a>
            @endif

            @if (auth()->user()->hasRole('acarya|helper'))
                @if (auth()->user()->hasRole('acarya|helper'))
                    <a href="/requests"
                       class="appMenu-item {{ Str::startsWith( request()->path(), 'requests') ? 'active' : '' }}">
                        <span class="appMenu-itemIcon appIcons msppIcons-list1"></span>
                        <span class="appMenu-itemText">{{ __('Requests') }}</span>
                        <requests-count-badge></requests-count-badge>
                    </a>
                    <a href="/initiations"
                       class="appMenu-item {{ Str::startsWith( request()->path(), 'initiations') ? 'active' : '' }}">
                        <span class="appMenu-itemIcon appIcons msppIcons-disc"></span>
                        <span class="appMenu-itemText">{{ __('Initiations') }}</span>
                    </a>
                @endif
                @if (auth()->user()->hasRole('acarya'))
                    <a href="/conversations"
                       class="appMenu-item {{ Str::startsWith( request()->path(), 'conversations') ? 'active' : '' }}">
                        <span class="appMenu-itemIcon appIcons msppIcons-mail"></span>
                        <span class="appMenu-itemText">{{ __('Conversations') }}</span>
                        <questions-unread-badge></questions-unread-badge>
                    </a>
                @endif
            @endif
            @if (auth()->user()->hasRole('admin|geo|secretary|bp|trustee|watcher'))
                @if (auth()->user()->hasRole('admin|secretary|bp|trustee|watcher'))
                    <a href="/users"
                       class="appMenu-item {{ Str::startsWith( request()->path(), 'users') ? 'active' : '' }}">
                        <span class="appMenu-itemIcon appIcons msppIcons-users"></span>
                        <span class="appMenu-itemText">{{ __('All users') }}</span>
                    </a>
                @endif
                @if(auth()->user()->hasRole('admin|geo'))
                    <a href="/geo"
                       class="appMenu-item {{ Str::endsWith( request()->path(), 'geo') ? 'active' : '' }}">
                        <span class="appMenu-itemIcon appIcons msppIcons-map-pin"></span>
                        <span class="appMenu-itemText">{{ __('GEO regions') }}</span>
                    </a>
                    <a href="/geo-report"
                       class="appMenu-item {{ Str::endsWith( request()->path(), 'geo-report') ? 'active' : '' }}">
                        <span class="appMenu-itemIcon appIcons msppIcons-award"></span>
                        <span class="appMenu-itemText">{{ __('GEO reports') }}</span>
                    </a>
                @endif
                @if (auth()->user()->hasRole('admin|acarya'))
                    <a href="/statistics"
                       class="appMenu-item {{ Str::startsWith( request()->path(), 'statistic') ? 'active' : '' }}">
                        <span class="appMenu-itemIcon appIcons msppIcons-trending-up"></span>
                        <span class="appMenu-itemText">{{ __('Statistics') }}</span>
                    </a>
                @endif
            @endif
            @if (auth()->user()->hasRole('admin'))
                <a href="/spiritual-names"
                   class="appMenu-item {{ Str::startsWith( request()->path(), 'spiritual-names') ? 'active' : '' }}">
                    <span class="appMenu-itemIcon appIcons msppIcons-pen-tool"></span>
                    <span class="appMenu-itemText">{{ __('Spiritual names handbook') }}</span>
                </a>
            @endif
        @endif

        @if (auth()->check())
            <a href="/profile"
               class="appMenu-item {{ Str::startsWith( request()->path(), 'profile') ? 'active' : '' }}">
                <span class="appMenu-itemIcon appIcons msppIcons-user"></span>
                <span class="appMenu-itemText">{{ __('Profile') }}</span>
            </a>
            <a href="{{ route('logout') }}" class="appMenu-item"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <span class="appMenu-itemIcon appIcons msppIcons-log-out"></span>
                <span class="appMenu-itemText">{{ __('Logout') }}</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                  style="display: none;">
                @csrf
            </form>
    </div>
    @endif
@endsection
