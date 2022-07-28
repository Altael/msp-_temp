<?php

namespace App\Providers;

use App\Contracts\Blog\PostsRepositoryInterface;
use App\Contracts\Geolocation\AcaryaGeoRepositoryInterface;
use App\Contracts\Geolocation\DioceseRepositoryInterface;
use App\Contracts\Geolocation\DistrictAreaRepositoryInterface;
use App\Contracts\Geolocation\DistrictAreaTasksRepositoryInterface;
use App\Contracts\Geolocation\DistrictRepositoryInterface;
use App\Contracts\Geolocation\SectorRepositoryInterface;
use App\Contracts\Geolocation\RegionRepositoryInterface;
use App\Contracts\Geolocation\RegionServiceInterface;
use App\Contracts\Handbooks\FastingsRepositoryInterface;
use App\Contracts\Handbooks\PuzzlesRepositoryInterface;
use App\Contracts\Handbooks\SpiritualNamesRepositoryInterface;
use App\Contracts\MeditationLessons\DelegatedLessonsRepositoryInterface;
use App\Contracts\MeditationLessons\LessonsRequestsRepositoryInterface;
use App\Contracts\MeditationLessons\MeditationLessonsRepositoryInterface;
use App\Contracts\MeditationLessons\MeditationLessonsServiceInterface;
use App\Contracts\MeditationLessons\MissingLessonsRepositoryInterface;
use App\Contracts\MeditationLessons\MissingLessonsServiceInterface;
use App\Contracts\Questions\QuestionMessagesRepositoryInterface;
use App\Contracts\Questions\QuestionsRepositoryInterface;
use App\Contracts\UnitProgramsRepositoryInterface;
use App\Contracts\User\AcaryaHelperRepositoryInterface;
use App\Contracts\User\LftRepositoryInterface;
use App\Contracts\User\SocialAuthInterface;
use App\Contracts\User\UserPlacesRepositoryInterface;
use App\Contracts\User\UserProfileRepositoryInterface;
use App\Contracts\User\UserRepositoryInterface;
use App\Contracts\User\UserRolesRepositoryInterface;
use App\Contracts\User\UserServiceInterface;
use App\Contracts\User\UserSocialsRepositoryInterface;
use App\Contracts\User\UserTeachersRepositoryInterface;
use App\Repositories\Blog\PostsRepository;
use App\Repositories\Geolocation\AcaryaGeoRepository;
use App\Repositories\Geolocation\DioceseRepository;
use App\Repositories\Geolocation\DistrictAreaRepository;
use App\Repositories\Geolocation\DistrictAreaTasksRepository;
use App\Repositories\Geolocation\DistrictRepository;
use App\Repositories\Geolocation\RegionRepository;
use App\Repositories\Geolocation\SectorRepository;
use App\Repositories\Handbooks\FastingsRepository;
use App\Repositories\Handbooks\PuzzlesRepository;
use App\Repositories\MeditationLessons\DelegatedLessonsRepository;
use App\Repositories\MeditationLessons\LessonsRequestsRepository;
use App\Repositories\MeditationLessons\MeditationLessonsRepository;
use App\Repositories\MeditationLessons\MissingLessonsRepository;
use App\Repositories\Questions\QuestionMessagesRepository;
use App\Repositories\Questions\QuestionsRepository;
use App\Repositories\UnitProgramsRepository;
use App\Repositories\User\AcaryaHelperRepository;
use App\Repositories\User\LftRepository;
use App\Repositories\Handbooks\SpiritualNamesRepository;
use App\Repositories\User\UserPlacesRepository;
use App\Repositories\User\UserProfileRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRolesRepository;
use App\Repositories\User\UserSocialsRepository;
use App\Repositories\User\UserTeachersRepository;
use App\Services\Geolocation\RegionService;
use App\Services\MeditationLessons\MeditationLessonsService;
use App\Services\MeditationLessons\MissingLessonsService;
use App\Services\User\SocialAuthService;
use App\Services\User\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        if (app()->environment('local')) {
            app()->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        $this->registerGeolocation();
        $this->registerUser();
        $this->registerMeditationLessons();
        $this->registerQuestions();
        $this->registerHandbooks();
        $this->registerBlog();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }

    private function registerGeolocation(): void
    {
        $this->app->bind(SectorRepositoryInterface::class, SectorRepository::class);
        $this->app->bind(RegionRepositoryInterface::class, RegionRepository::class);
        $this->app->bind(DioceseRepositoryInterface::class, DioceseRepository::class);
        $this->app->bind(DistrictRepositoryInterface::class, DistrictRepository::class);
        $this->app->bind(DistrictAreaRepositoryInterface::class, DistrictAreaRepository::class);
        $this->app->bind(RegionServiceInterface::class, RegionService::class);
        $this->app->bind(UserPlacesRepositoryInterface::class, UserPlacesRepository::class);
        $this->app->bind(DistrictAreaTasksRepositoryInterface::class, DistrictAreaTasksRepository::class);
        $this->app->bind(AcaryaGeoRepositoryInterface::class, AcaryaGeoRepository::class);
        $this->app->bind(UnitProgramsRepositoryInterface::class, UnitProgramsRepository::class);
    }

    private function registerUser(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(SocialAuthInterface::class, SocialAuthService::class);
        $this->app->bind(UserSocialsRepositoryInterface::class, UserSocialsRepository::class);
        $this->app->bind(UserTeachersRepositoryInterface::class, UserTeachersRepository::class);
        $this->app->bind(UserProfileRepositoryInterface::class, UserProfileRepository::class);
        $this->app->bind(AcaryaHelperRepositoryInterface::class, AcaryaHelperRepository::class);
        $this->app->bind(UserRolesRepositoryInterface::class, UserRolesRepository::class);
        $this->app->bind(LftRepositoryInterface::class, LftRepository::class);
    }

    private function registerMeditationLessons(): void
    {
        $this->app->bind(LessonsRequestsRepositoryInterface::class, LessonsRequestsRepository::class);
        $this->app->bind(MeditationLessonsRepositoryInterface::class, MeditationLessonsRepository::class);
        $this->app->bind(MeditationLessonsServiceInterface::class, MeditationLessonsService::class);
        $this->app->bind(DelegatedLessonsRepositoryInterface::class, DelegatedLessonsRepository::class);
        $this->app->bind(MissingLessonsServiceInterface::class, MissingLessonsService::class);
        $this->app->bind(MissingLessonsRepositoryInterface::class, MissingLessonsRepository::class);
    }

    private function registerQuestions(): void
    {
        $this->app->bind(QuestionMessagesRepositoryInterface::class, QuestionMessagesRepository::class);
        $this->app->bind(QuestionsRepositoryInterface::class, QuestionsRepository::class);
    }

    private function registerHandbooks(): void
    {
        $this->app->bind(SpiritualNamesRepositoryInterface::class, SpiritualNamesRepository::class);
        $this->app->bind(FastingsRepositoryInterface::class, FastingsRepository::class);
        $this->app->bind(PuzzlesRepositoryInterface::class, PuzzlesRepository::class);
    }

    private function registerBlog(): void
    {
        $this->app->bind(PostsRepositoryInterface::class, PostsRepository::class);
    }
}
