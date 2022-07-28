<?php

namespace App\Providers;

use App\Events\LessonWasGiven;
use App\Events\NewLessonRequestAdded;
use App\Events\NewQuestionMessageAdded;
use App\Events\SpiritualNameChanged;
use App\Events\UserAddedToUnit;
use App\Listeners\NotifyAboutNewLessonRequest;
use App\Listeners\NotifyAboutNewQuestionMessage;
use App\Listeners\NotifyBPAboutInitiation;
use App\Listeners\NotifyUSAboutNewUser;
use App\Listeners\NotifyUserAboutHisUnit;
use App\Listeners\NotifyUserAboutSpiritualName;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use JhaoDa\SocialiteProviders\MailRu\MailRuExtendSocialite;
use SocialiteProviders\Manager\SocialiteWasCalled;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        SocialiteWasCalled::class => [
            'SocialiteProviders\\VKontakte\\VKontakteExtendSocialite@handle',
            'SocialiteProviders\\Yandex\\YandexExtendSocialite@handle',
            MailRuExtendSocialite::class
        ],

        NewQuestionMessageAdded::class => [
            NotifyAboutNewQuestionMessage::class
        ],

        NewLessonRequestAdded::class => [
            NotifyAboutNewLessonRequest::class
        ],

        LessonWasGiven::class => [
            NotifyBPAboutInitiation::class
        ],

        SpiritualNameChanged::class => [
            NotifyUserAboutSpiritualName::class
        ],

        UserAddedToUnit::class => [
            NotifyUSAboutNewUser::class,
            NotifyUserAboutHisUnit::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
