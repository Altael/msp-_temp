@if (auth()->check())
    <div class="appMenu effectScale-target">
        <div class="dhrtScroll-wrapperOuter">
            <div class="dhrtScroll-wrapperInner">
                <div class="appMenu-content">
                    @if (auth()->user()->isRegistrationCompleted() && auth()->user()->amAllowed())

                        @if (!auth()->user()->hasRole('acarya'))
                            <div class="appMenu-group {{ auth()->user()->hasRole('helper') ? 'appMenu-groupCombo' : '' }}">
                                <div class="appMenu-groupTitle">
                                    {{ __('For sadhaka') }}
                                </div>
                                <a href="/user/request"
                                   class="appMenu-item {{ Str::startsWith( request()->path(), 'user/request') ? 'active' : '' }}">
                                    <span class="appMenu-itemIcon appIcons msppIcons-feather"></span>
                                    <span class="appMenu-itemText">{{ __('Requests') }}</span>
                                </a>
                                @if(auth()->user()->currentLesson)
                                    <a href="/user/lessons"
                                       class="appMenu-item {{ Str::startsWith( request()->path(), 'user/lessons') ? 'active' : '' }}">
                                        <span class="appMenu-itemIcon appIcons msppIcons-edit-3"></span>
                                        <span class="appMenu-itemText">{{ __('Lessons') }}</span>
                                    </a>
                                    <a href="/user/conversations"
                                       class="appMenu-item {{ Str::startsWith( request()->path(), 'user/conversations') ? 'active' : '' }}">
                                        <span class="appMenu-itemIcon appIcons msppIcons-edit"></span>
                                        <span
                                            class="appMenu-itemText">{{ __('Question to') }} {{ auth()->user()->profile->sex === 'male' ? __('Dada ') : __('Didi') }}</span>
                                        <questions-unread-badge></questions-unread-badge>
                                    </a>
                                @endif
                            </div>
                        @endif
                    @if(!auth()->user()->sadvipra || auth()->user()->hasRole('diary'))
                        <div class="appMenu-group">
                            {{--<a href="/materials" class="appMenu-item {{ Str::startsWith( request()->path(), 'materials') ? 'active' : '' }}">
                                <span class="appMenu-itemIcon appIcons msppIcons-archive"></span>
                                <span class="appMenu-itemText">{{ __('Useful materials') }}</span>
                            </a>--}}
                            @if(auth()->user()->sadvipra)
                                <a href="/diary"
                                   class="appMenu-item {{ Str::endsWith( request()->path(), 'diary') ? 'active' : '' }}">
                                    <span class="appMenu-itemIcon appIcons msppIcons-book"></span>
                                    <span class="appMenu-itemText">{{ __('Diary') }}</span>
                                </a>
                            @endif
                            @if (auth()->user()->hasRole('diary'))
                                <a href="/diary-edit"
                                   class="appMenu-item {{ Str::endsWith( request()->path(), 'diary-edit') ? 'active' : '' }}">
                                    <span class="appMenu-itemIcon appIcons msppIcons-book"></span>
                                    <span class="appMenu-itemText">{{ __('Diaries settings') }}</span>
                                </a>
                            @endif
                        </div>
                    @endif

                        {{--<div class="appMenu-group">
                            <a href="/news"
                               class="appMenu-item {{ Str::endsWith( request()->path(), 'news') ? 'active' : '' }}">
                                <span class="appMenu-itemIcon appIcons msppIcons-pen-tool"></span>
                                <span class="appMenu-itemText">{{ __('News') }}</span>
                            </a>
                        </div>--}}

                        @if (auth()->user()->hasRole('acarya|helper'))
                            <div class="appMenu-group {{ !auth()->user()->hasRole('acarya') ? 'appMenu-groupCombo' : '' }}">
                                <div class="appMenu-groupTitle">
                                    @if(auth()->user()->hasRole('helper'))
                                        {{ __('For assistant') }}
                                    @else
                                        {{ __('For acarya') }}
                                    @endif
                                </div>
                                @if (auth()->user()->hasRole('acarya|helper'))
                                    <div :class="{'expandable': ($root.roles.includes('admin') || $root.roles.includes('bc'))}">
                                        <requests-count-badge></requests-count-badge>
                                        <a href="/requests"
                                           class="appMenu-item {{ Str::endsWith( request()->fullUrl(), '/requests') ? 'active' : '' }}">
                                            <span class="appMenu-itemIcon appIcons msppIcons-list1"></span>
                                            <span class="appMenu-itemText">{{ __('Requests') }}</span>
                                        </a>
                                        <a href="/requests?helper_filter=1"
                                           class="appMenu-item {{ Str::endsWith( request()->fullUrl(), 'requests?helper_filter=1') ? 'active' : '' }}">
                                            <span class="appMenu-itemIcon appIcons msppIcons-list1"></span>
                                            <span class="appMenu-itemText">{{ __('Initiation requests') }}</span>
                                        </a>
                                        <a href="/requests?helper_filter=2"
                                           class="appMenu-item {{ Str::endsWith( request()->fullUrl(), 'requests?helper_filter=2') ? 'active' : '' }}">
                                            <span class="appMenu-itemIcon appIcons msppIcons-list1"></span>
                                            <span class="appMenu-itemText">{{ __('2-6 lessons requests') }}</span>
                                        </a>
                                        <a href="/requests?helper_filter=3"
                                           class="appMenu-item {{ Str::endsWith( request()->fullUrl(), 'requests?helper_filter=3') ? 'active' : '' }}">
                                            <span class="appMenu-itemIcon appIcons msppIcons-list1"></span>
                                            <span class="appMenu-itemText">{{ __('Lesson checks') }}</span>
                                        </a>
                                        <a href="/initiations"
                                           class="appMenu-item {{ Str::startsWith( request()->path(), 'initiations') ? 'active' : '' }}">
                                            <span class="appMenu-itemIcon appIcons msppIcons-disc"></span>
                                            <span class="appMenu-itemText">{{ __('Users initiated by acarya') }}</span>
                                        </a>
                                    </div>
                                @endif
                                @if (auth()->user()->hasRole('acarya'))
                                    <a href="/conversations"
                                       class="appMenu-item {{ Str::startsWith( request()->path(), 'conversations') ? 'active' : '' }}">
                                        <span class="appMenu-itemIcon appIcons msppIcons-mail"></span>
                                        <span class="appMenu-itemText">{{ __('Conversations') }}</span>
                                        <questions-unread-badge></questions-unread-badge>
                                    </a>
                                @endif
                            </div>
                        @endif
                        @if (auth()->user()->hasRole('admin|geo|geo-editor|secretary|bp|trustee|watcher|programmer|dean|curator|bc|statistics_viewer'))
                            <div class="appMenu-group">
                                @if (auth()->user()->hasRole('admin|secretary|bp|trustee|watcher|dean|curator'))
                                    <a href="/users"
                                       class="appMenu-item {{ Str::startsWith( request()->path(), 'users') ? 'active' : '' }}">
                                        <span class="appMenu-itemIcon appIcons msppIcons-users"></span>
                                        <span class="appMenu-itemText">{{ __('All users') }}</span>
                                    </a>
                                @endif
                                @if (auth()->user()->hasRole('admin|curator'))
                                    <a href="/call-requests"
                                       class="appMenu-item {{ Str::startsWith( request()->path(), 'call-requests') ? 'active' : '' }}">
                                        <span class="appMenu-itemIcon appIcons msppIcons-pounds"></span>
                                        <span class="appMenu-itemText">{{ __('Sadvipra path') }}</span>
                                    </a>
                                @endif
                                @if (auth()->user()->hasRole('admin|dean'))
                                    <a href="/curators"
                                       class="appMenu-item {{ Str::startsWith( request()->path(), 'curators') ? 'active' : '' }}">
                                        <span class="appMenu-itemIcon appIcons msppIcons-sil"></span>
                                        <span class="appMenu-itemText">{{ __('Curators') }}</span>
                                    </a>
                                @endif
                                @if (auth()->user()->hasRole('admin'))
                                    <a href="/statuses"
                                       class="appMenu-item {{ Str::startsWith( request()->path(), 'statuses') ? 'active' : '' }}">
                                        <span class="appMenu-itemIcon appIcons msppIcons-airplay"></span>
                                        <span class="appMenu-itemText">{{ __('Unit status') }}</span>
                                    </a>
                                @endif
                                @if(auth()->user()->hasRole('admin|bp|geo|geo-editor|bc'))
                                    <a href="/geo"
                                       class="appMenu-item {{ Str::endsWith( request()->path(), 'geo') ? 'active' : '' }}">
                                        <span class="appMenu-itemIcon appIcons msppIcons-map-pin"></span>
                                        <span class="appMenu-itemText">{{ __('GEO regions') }}</span>
                                    </a>
                                    @if(auth()->user()->hasRole('admin|geo|geo-editor'))
                                        <a href="/geo-report"
                                           class="appMenu-item {{ Str::endsWith( request()->path(), 'geo-report') ? 'active' : '' }}">
                                            <span class="appMenu-itemIcon appIcons msppIcons-award"></span>
                                            <span class="appMenu-itemText">{{ __('GEO reports') }}</span>
                                        </a>
                                    @endif
                                    {{--<a href="/" class="appMenu-item disabled">
                                        <span class="appMenu-itemIcon appIcons msppIcons-send"></span>
                                        <span class="appMenu-itemText">{{ __('Mailing lists') }}</span>
                                    </a>--}}
                                @endif
                                @if (auth()->user()->hasRole('admin|acarya|statistics_viewer'))
                                    <a href="/statistics"
                                       class="appMenu-item {{ Str::startsWith( request()->path(), 'statistic') ? 'active' : '' }}">
                                        <span class="appMenu-itemIcon appIcons msppIcons-trending-up"></span>
                                        <span class="appMenu-itemText">{{ __('Statistics') }}</span>
                                    </a>
                                @endif
                                @if (auth()->user()->hasRole('admin|bc|acb|vmtr|bp|secretary'))
                                    <a href="/events-report"
                                       class="appMenu-item {{ Str::startsWith( request()->path(), 'events-report') ? 'active' : '' }}">
                                        <span class="appMenu-itemIcon appIcons msppIcons-trending-up"></span>
                                        <span class="appMenu-itemText">{{ __('Events Report') }}</span>
                                    </a>
                                @endif
                            </div>
                        @endif
                        @if (auth()->user()->hasRole('admin||blogger'))
                            <div class="appMenu-group">
                                @if (auth()->user()->hasRole('admin'))
                                <a href="/spiritual-names"
                                   class="appMenu-item {{ Str::startsWith( request()->path(), 'spiritual-names') ? 'active' : '' }}">
                                    <span class="appMenu-itemIcon appIcons msppIcons-pen-tool"></span>
                                    <span class="appMenu-itemText">{{ __('Spiritual names handbook') }}</span>
                                </a>
                                <a href="/missing-lessons"
                                   class="appMenu-item {{ Str::startsWith( request()->path(), 'missing-lessons') ? 'active' : '' }}">
                                    <span class="appMenu-itemIcon appIcons msppIcons-lessons"></span>
                                    <span class="appMenu-itemText">{{ __('Missing lessons requests') }}</span>
                                </a>
                                <a href="/fastings"
                                   class="appMenu-item {{ Str::startsWith( request()->path(), 'fastings') ? 'active' : '' }}">
                                    <span class="appMenu-itemIcon appIcons msppIcons-upavasa"></span>
                                    <span class="appMenu-itemText">{{ __('Fastings list') }}</span>
                                </a>
                                @endif
                                <a href="/puzzle-edit"
                                   class="appMenu-item {{ Str::startsWith( request()->path(), 'puzzle-edit') ? 'active' : '' }}">
                                    <span class="appMenu-itemIcon appIcons msppIcons-tag"></span>
                                    <span class="appMenu-itemText">{{ __('Reward editor') }}</span>
                                </a>
                                <a href="/blog_admin"
                                   class="appMenu-item {{ Str::startsWith( request()->path(), 'blog_admin') ? 'active' : '' }}">
                                    <span class="appMenu-itemIcon appIcons msppIcons-file-openoffice"></span>
                                    <span class="appMenu-itemText">{{ __('Posts editor') }}</span>
                                </a>
                                <a href="/posts-lang"
                                   class="appMenu-item {{ Str::startsWith( request()->path(), 'posts-edit') ? 'active' : '' }}">
                                    <span class="appMenu-itemIcon appIcons msppIcons-support"></span>
                                    <span class="appMenu-itemText">{{ __('Posts language') }}</span>
                                </a>
                                <a href="/posts-categories"
                                   class="appMenu-item {{ Str::startsWith( request()->path(), 'posts-categories') ? 'active' : '' }}">
                                    <span class="appMenu-itemIcon appIcons msppIcons-karmayoga"></span>
                                    <span class="appMenu-itemText">{{ __('Posts categories relations') }}</span>
                                </a>
                                <a href="/media-library"
                                   class="appMenu-item {{ Str::startsWith( request()->path(), 'media-library') ? 'active' : '' }}">
                                    <span class="appMenu-itemIcon appIcons msppIcons-stop-circle"></span>
                                    <span class="appMenu-itemText">{{ __('Media files library') }}</span>
                                </a>
                                <a href="/programs"
                                   class="appMenu-item {{ Str::startsWith( request()->path(), 'programs') ? 'active' : '' }}">
                                    <span class="appMenu-itemIcon appIcons msppIcons-status3"></span>
                                    <span class="appMenu-itemText">{{ __('Units programs') }}</span>
                                </a>
                            </div>
                        @endif
                        @if(auth()->user()->hasRole('singer|admin'))
                            <a href="/samgiits-edit"
                               class="appMenu-item {{ Str::startsWith( request()->path(), 'samgiits-edit') ? 'active' : '' }}">
                                <span class="appMenu-itemIcon appIcons msppIcons-pen-tool"></span>
                                <span class="appMenu-itemText">{{ __('Prabhat samgits editor') }}</span>
                            </a>
                        @endif

                    @endif

                    <div class="appMenu-group">
                        @include('layouts/support')

                    </div>

                    <div class="appMenu-group">
                        @if( auth()->user()->amAllowed())
                        <a href="/profile"
                           class="appMenu-item {{ Str::startsWith( request()->path(), 'profile') ? 'active' : '' }}">
                            <span class="appMenu-itemIcon appIcons msppIcons-user"></span>
                            <span class="appMenu-itemText">{{ __('Profile') }}</span>
                            @if (auth()->user()->notify_name)
                                <div class="appUnreadSpiritualName appBadge">
                                    {{ __('Name') }}
                                </div>
                            @endif
                        </a>
                        @endif
                        <install-pwa></install-pwa>
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
                </div>
            </div>
        </div>
    </div>
@else
    <div class="appLogin-support">
        @include('layouts/support')
    </div>
@endif
