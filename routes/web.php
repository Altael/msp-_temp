<?php

Route::get('/login/email', 'ViewsController@loginByEmail');
Auth::routes();

// Please do not remove test route
if (app()->environment('dev')) {
    Route::get('/test', 'TestController@test')->name('test');
}

Route::group(['middleware' => ['auth', 'check.for.registration.completed', 'secretary.access']], static function() {
    Route::get('/unit-statistics', 'ViewsController@unitStatistics');
});

Route::group(['middleware' => ['auth', 'check.for.registration.completed', 'bp.access']], static function() {
    Route::get('/bhukti-statistics', 'ViewsController@bhuktiStatistics');
});

// Role above Sadhaka
Route::group(['middleware' => ['auth', 'check.for.registration.completed']], static function () {
    Route::get('/', 'ViewsController@home')->name('home');
    Route::get('/home', 'ViewsController@home')->name('home');
    Route::get('/requests', 'ViewsController@requests');
    Route::get('/initiations', 'ViewsController@initiations');
    Route::get('/conversations', 'ViewsController@conversations');
    Route::get('/diary-edit', 'ViewsController@diaryEdit');
    Route::get('/spiritual-names', 'ViewsController@sNames');
    Route::get('/missing-lessons', 'ViewsController@missingLessons');
    Route::get('/puzzle-edit', 'ViewsController@puzzleEdit');
    Route::get('/posts-lang', 'ViewsController@postsLang');
    Route::get('/posts-categories', 'ViewsController@postsCategories');
    Route::get('/lessons-requirements', 'ViewsController@lessonReqs');
    Route::get('/media-library', 'ViewsController@media');
    Route::get('/programs', 'ViewsController@programs');
    Route::get('/404', 'ViewsController@adminPanel');
    Route::get('/destroy-user/{id}', 'UsersController@destroy');

    Route::get('/diary-settings', 'DailyPracticesEditController@index');
    Route::post('/diary-settings', 'DailyPracticesEditController@store');
    Route::post('/change-acarya', 'User\AcaryaHelpersController@changeAcarya');
    Route::get('/acaryas', 'UserProfileController@getAcaryas');
    Route::get('/materials', 'UsefulMaterialsController@index');
    Route::put('/lft', 'User\LftController@update');
    Route::apiResource('/names', 'SpiritualNamesController');
    Route::get('/missing-lessons-handbook', 'MissingLessonsController@index');
    Route::put('/missing-lesson-accept', 'MissingLessonsController@accept');
    Route::put('/missing-lesson-decline', 'MissingLessonsController@decline');
    Route::get('/posts-categories-list', 'CategoriesController@index');
    Route::post('/posts-categories-list', 'CategoriesController@store');
    Route::apiResource('/puzzles', 'PuzzlesController');
    Route::get('/posts-resource-list', 'PostsController@list');
    Route::post('/posts-resource-edit', 'PostsController@store');
    Route::get('/lessons-requirements-list', 'LessonsReqsController@index');
    Route::post('/lessons-requirements-list', 'LessonsReqsController@store');
    Route::get('/get-media-lib-list', 'MediaController@list');
    Route::get('/delete-media', 'MediaController@delete');
    Route::post('/post-image', 'MediaController@test');
    Route::get('/programs-list', 'ProgramsController@index');
    Route::post('/programs-list', 'ProgramsController@save');
});

// Accessible all the time
Route::group(['middleware' => ['auth']], static function () {
    Route::get('/policy', 'DocsController@policy');
    Route::get('/terms', 'DocsController@terms');
    Route::get('/newsletter', 'DocsController@newsletter');
    Route::get('/offer', 'DocsController@offer');
    Route::get('/user-info', 'UsersController@info');
});

// API
Route::middleware(['auth', 'check.for.registration.completed'])->group(function () {
    Route::get('/statistics', 'ViewsController@statistics');
    Route::prefix('/statistics')->group(function () {
        Route::get('/table', 'StatisticsController@table');
    });
    Route::get('/statistics/main', 'StatisticsController@index');
    Route::get('/statistics/lessons', 'StatisticsController@lessons');
    Route::get('/statistics/initiations', 'StatisticsController@initiations');
    Route::get('/statistics/units', 'StatisticsController@getUnitsEvents');
    Route::get('/statistics/report', 'StatisticsController@getEventsReport');
    Route::get('/get-user-avatar', 'MediaController@getUserAvatar');
    Route::get('/user-meditation-lesson', 'MeditationLessons\MeditationLessonsController@getLastUserLesson');
    Route::get('/user-meditation-lessons', 'MeditationLessons\MeditationLessonsController@getUserLessons');
    Route::put('/save-user-lessons', 'MeditationLessons\MeditationLessonsController@saveUserLessons');
    Route::get('/from-meditation-lessons', 'MeditationLessons\MeditationLessonsController@getFromUserLastLessons');
    Route::get('/requests-count', 'MeditationLessons\MeditationLessonsController@getLessonsCount');
    Route::get('/initiations-count', 'MeditationLessons\MeditationLessonsController@getInitiationsCount');
    Route::post('/lesson-request', 'MeditationLessons\MeditationLessonsController@saveLessonRequest');
    Route::post('/missing-request', 'MeditationLessons\MeditationLessonsController@saveMissingRequest');
    Route::get('/lesson-request', 'MeditationLessons\MeditationLessonsController@getAllLessonRequests');
    Route::delete('/lesson-request', 'MeditationLessons\MeditationLessonsController@deleteLessonRequest');
    Route::post('/approve-lesson-request', 'MeditationLessons\MeditationLessonsController@approveLessonRequest');
    Route::post('/cancel-lesson-request', 'MeditationLessons\MeditationLessonsController@cancelLessonRequest');
    Route::post('/delegate-lesson-request', 'MeditationLessons\MeditationLessonsController@delegateLessonRequest');

    Route::get('/events-report', 'ViewsController@eventsReport');

    Route::post('/spiritual-name', 'UserProfileController@changeInitiationUser');

    Route::get('/users', 'ViewsController@users');
    Route::get('/samgiits-edit', 'ViewsController@samgiitsEdit');

    Route::get('/question-message', 'Questions\QuestionsController@getQuestionMessages');
    Route::get('/question', 'Questions\QuestionsController@getQuestions');
    Route::get('/questions', 'Questions\QuestionsController@getQuestionDates');
    Route::post('/question', 'Questions\QuestionsController@saveQuestion');
    Route::post('/question-message', 'Questions\QuestionsController@saveMessage');
    Route::get('/question-unread-message-count', 'Questions\QuestionsController@unreadMessageCount');
    Route::post('/question-status', 'Questions\QuestionsController@updateQuestionStatus');

    Route::get('/notifications', 'NotificationsController@index');
    Route::post('/notifications', 'NotificationsController@store');

    Route::get('/diary', 'ViewsController@diary');
    Route::get('/diary-record', 'ViewsController@diaryRecord');
    Route::get('/diary-day', 'ViewsController@diaryDay');
    Route::get('/user-diary-info', 'DailyPracticesController@getAverageForUser');
    Route::prefix('reward')->group(function () {
        Route::get('/daily', 'PuzzlesController@daily');
        Route::get('/svadhyaya', 'PuzzlesController@svadhyaya');
        Route::get('/quote', 'PuzzlesController@ownedQuotes');
        Route::get('/story', 'PuzzlesController@ownedStories');
    });

    Route::get('/easter-egg', 'EasterEggController@index');
    Route::post('/easter-egg', 'EasterEggController@store');
    Route::get('/bnk', 'ViewsController@eEgg');

    Route::get('/profile', 'ViewsController@profile');

    Route::get('/geo', 'ViewsController@geo');
    Route::get('/geo-report', 'GeoController@index');

    Route::get('telegram-connect', 'TelegramController@index');
    Route::get('telegram-disconnect', 'TelegramController@disconnect');

    Route::get('conversations-dialogue', 'ConversationsController@index');

    Route::get('/user-locale/{locale}', 'UsersController@setLocale');

    Route::put('/like/{post}', 'PostsController@like');
    Route::get('/posts/{category}', 'ViewsController@posts');
    Route::get('/category/{category}', 'ViewsController@category');
    Route::get('/posts-data/{category}', 'PostsController@index');
    Route::get('/education', 'ViewsController@education');
    Route::get('/practices', 'ViewsController@practices');
    Route::get('/education/{category}', 'ViewsController@category');
    Route::get('/practices/{category}', 'ViewsController@category');
    Route::get('/post/{post}', 'ViewsController@post');
    Route::get('/education/post/{post}', 'ViewsController@post');
    Route::get('/practices/post/{post}', 'ViewsController@post');
    Route::get('/post-data/{post}', 'PostsController@show');
    Route::get('/news', 'ViewsController@news');
    Route::get('/get-books', 'BooksController@index');
    Route::get('/dc', 'ViewsController@dharmacakra');
    Route::get('/get-samgits', 'DharmacakraController@samgits');
    Route::get('/get-mantras', 'DharmacakraController@mantras');
    Route::put('/favorite/{samgit}', 'DharmacakraController@favorite');

    Route::post('/upload-file', 'MediaController@upload');
    Route::post('/save-file', 'MediaController@save');

    Route::get('/connect-mobile-app', 'UsersController@connectMobileApp');
    Route::get('/disconnect-mobile-app', 'UsersController@disconnectMobileApp');
    Route::get('/get-user-practices', 'UsersController@getUserPractices');

    Route::get('/unit', 'ViewsController@unit');
    Route::get('/unit-programs', 'ViewsController@unitPrograms');
    Route::get('/unit-info', 'Geolocation\UnitController@info');

    Route::get('/nearest-fasting', 'FastingsController@nearestFasting');
    Route::get('/fastings', 'ViewsController@fastings');
    Route::get('/fastings-handbook', 'FastingsController@index');

    Route::get('/database-request', 'DatabaseController@index');

    Route::post('/set-practices-difficulty', 'UserProfileController@setPracticesDifficulty');
    Route::post('/set-fastings-amount', 'UserProfileController@setFastingsAmount');
    Route::post('/set-sex', 'UserProfileController@setSex');
    Route::get('/get-locales/{field}', 'LocaleController@index');
    Route::post('/sub-locale/{table}/{field}/{locale}', 'LocaleController@set');
    Route::get('/get-audio-files', 'MediaController@getAudio');
    Route::get('/get-video-files', 'MediaController@getVideo');

    Route::apiResource('/unit-programs-api', 'UnitProgramsController');

    Route::get('/settings/{entity}', 'SettingsController@getSettings');
    Route::post('/settings/{entity}', 'SettingsController@postSettings');

    Route::get('/statuses', 'ViewsController@statuses');
    Route::get('/get-statuses', 'StatusesController@index');
    Route::post('/save-status', 'StatusesController@save');
    Route::post('/destroy-status/{id}', 'StatusesController@delete');
    Route::post('/save-unit-user-settings', 'UsersController@saveUnitSettings');

    Route::get('/get-unit-titles', 'Geolocation\UnitController@getTitles');
    Route::get('/get-roles', 'UsersController@getRoles');
    Route::post('/save-roles', 'UsersController@saveRoles');

    Route::get('/curators', 'ViewsController@curators');
    Route::post('/save-call-request', 'CallRequestsController@save');
    Route::post('/accept-call-request', 'CallRequestsController@accept');
    Route::post('/close-call-request', 'CallRequestsController@close');
    Route::post('/forward-call-request', 'CallRequestsController@forward');
    Route::get('/get-call-requests', 'CallRequestsController@index');
    Route::put('/edit-call-request', 'CallRequestsController@edit');
    Route::post('/confirm-100-hours', 'UserProfileController@confirm100hours');

    Route::get('/prabhat-samgiits', 'ViewsController@samgiitsPage');

    Route::get('/call-requests', 'ViewsController@callRequests');
    Route::get('/call-request', 'ViewsController@callRequest');

    Route::post('/start-course', 'CoursesController@startCourse');
    Route::post('/close-stage', 'StagesController@closeStage');

    Route::get('/svadhyaya', 'ViewsController@svadhyaya');
});

Route::prefix('api')->middleware(['auth'])->group(function () {
    Route::post('/log-save', 'HistoryController@saveHistoryLog');
    Route::get('/log-show', 'HistoryController@showEvents');

    Route::get('/geo-units', 'GeoController@getUnits');

    Route::get('/sectors', 'Geolocation\SectorController@index');
    Route::get('/sectors/{sector}', 'Geolocation\SectorController@show');
    Route::post('/sectors', 'Geolocation\SectorController@store');
    Route::delete('/sectors/{sector}', 'Geolocation\SectorController@destroy');
    Route::put('/sectors/{sector}', 'Geolocation\SectorController@update');

    Route::get('/regions', 'Geolocation\RegionController@index');
    Route::get('/regions/{region}', 'Geolocation\RegionController@show');
    Route::post('/regions', 'Geolocation\RegionController@store');
    Route::delete('/regions/{region}', 'Geolocation\RegionController@destroy');
    Route::put('/regions/{region}', 'Geolocation\RegionController@update');

    Route::get('/dioceses', 'Geolocation\DioceseController@index');
    Route::get('/dioceses/{diocese}', 'Geolocation\DioceseController@show');
    Route::post('/dioceses', 'Geolocation\DioceseController@store');
    Route::delete('/dioceses/{diocese}', 'Geolocation\DioceseController@destroy');
    Route::put('/dioceses/{diocese}', 'Geolocation\DioceseController@update');

    Route::get('/districts/match', 'Geolocation\DistrictController@match');
    Route::get('/districts', 'Geolocation\DistrictController@index');
    Route::get('/districts-full', 'Geolocation\DistrictController@full');
    Route::get('/districts/{district}', 'Geolocation\DistrictController@show');
    Route::post('/districts', 'Geolocation\DistrictController@store');
    Route::delete('/districts/{district}', 'Geolocation\DistrictController@destroy');
    Route::put('/districts/{district}', 'Geolocation\DistrictController@update');
    Route::post('/districts/bp', 'Geolocation\DistrictController@bp_works');
    Route::post('/districts/acarya', 'Geolocation\DistrictController@acarya_works');

    Route::get('/district-areas', 'Geolocation\DistrictAreaController@index');
    Route::post('/district-areas', 'Geolocation\DistrictAreaController@store');
    Route::delete('/district-areas/{districtArea}', 'Geolocation\DistrictAreaController@destroy');
    Route::put('/district-areas/{districtArea}', 'Geolocation\DistrictAreaController@update');

    Route::get('/units', 'Geolocation\UnitController@index');
    Route::get('/units/{unit}', 'Geolocation\UnitController@show');
    Route::post('/units', 'Geolocation\UnitController@store');
    Route::delete('/units/{unit}', 'Geolocation\UnitController@destroy');
    Route::put('/units/{unit}', 'Geolocation\UnitController@update');

    Route::get('/unit-users', 'Geolocation\UnitUsersController@index');
    Route::put('/user-title-works', 'UsersController@titleProcedure');

    Route::get('/get-user-tools-info/{id}', 'UsersController@getUserData');

    Route::get('/user-profile', 'UserProfileController@edit');
    Route::post('/user-profile', 'UserProfileController@update');
    Route::get('/user-cabinet', 'UserProfileController@cab');

    Route::post('/user-disable-name-notification', 'UserProfileController@nulifyNameNotification');

    Route::apiResource('/users', 'UsersController');
    Route::apiResource('/daily-practices', 'DailyPracticesController');
    Route::apiResource('/samgiits', 'SamgiitsController');
});

// User interface
Route::prefix('user')->middleware(['auth', 'check.for.registration.completed'])->group(function () {
    Route::get('/', 'User\HomeController@index');
    Route::get('/request', 'User\RequestsController@index');
    Route::get('/conversations', 'User\ConversationsController@index');
    Route::get('/lessons', 'User\LessonsController@index');
    Route::get('/profile', 'User\HomeController@profile');
    Route::get('/diary', 'User\HomeController@diary');
    Route::get('/missing-lessons', 'ViewsController@userMissingLessons');
});

Route::get('auth/{provider}', 'Auth\SocialAuthController@redirectToProvider')->name('social.redirect');
Route::get('auth/{provider}/callback', 'Auth\SocialAuthController@handleProviderCallback');

Route::get('/autocomplete', function () {
    return view('autocomplete');
});

Auth::routes(['verify' => true]);

Route::get('/docs', 'DocsController@redirect');

Route::get('/switch/{user}', 'UsersController@switch');

Route::any('bot', 'TelegramController@bot');


