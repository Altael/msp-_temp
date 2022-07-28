<?php

use App\Events\UserAddedToUnit;
use App\Models\User\User;
use App\MspMedia;
use App\Services\Geolocation\UserPlacesService;

Artisan::command('geo-test {name} {--place}', function (UserPlacesService $userPlacesService) {

    if ($this->option('place')) {
        dd($userPlacesService->getDetailsByPlaceId($this->argument('name'), 'ru'));
    }


    $predictions = $userPlacesService->getPlaceByName($this->argument('name'));


    foreach ($predictions['predictions'] as $prediction) {
        $id = $prediction['place_id'];

        $placeRu = $userPlacesService->getDetailsByPlaceId($id, 'ru');
        $placeEn = $userPlacesService->getDetailsByPlaceId($id, 'en');

        print_r([
            'components' => $placeRu['address_components'],
            'place_id' => $placeEn['place_id'],
            'en' => $placeEn['name'],
            'ru' => $placeRu['name'],
        ]);
    }
});

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote!');

Artisan::command('profile:hash-generate', function () {
    $userProfiles = \App\Models\User\UserProfile::all();

    foreach($userProfiles as $userProfile) {
        $userProfile->update([
            'hash_id' => md5($userProfile->user->id)
        ]);
    }
});

Artisan::command('users:unit-placement {--full}', function () {
    $users = \App\Models\User\User::query()->where('registration_completed', 1)->whereNotNull('district_area_id');

    if(!$this->option('full')) {
        $users->whereDoesntHave('units');
    }

    $users = $users->get();

    foreach($users as $user) {
        $districtArea = $user->districtArea;
        if ($unitId = $districtArea['default_unit_id']) {
            $user->units()->sync([$unitId]);
        }
    }
})->describe('Put users without unit to default units of their area.');

Artisan::command('download-books', function () {
    $books = json_decode(file_get_contents('https://digital.sattva-shop.ru/api/am'));

    foreach($books->books as $book) {
        $item = $book->book;

        $url = $item->field_thumbnail->src;
        $img = @file_get_contents($url);
        $name = substr($url, strrpos($url, '/') + 1);
        $trash = substr($url, strrpos($url, '?'));
        $name = str_replace($trash, '', $name);
        Storage::disk('media')->put($name, $img);

        \App\Book::create([
            'thumbnail' => $name,
            'title' => $item->title,
            'price' => $item->commerce_price,
            'description' => $item->body,
            'link' => $item->link
        ]);
    }

})->describe('Download books info from sattva-shop');

Artisan::command('fill-countries', function () {
    $places = \App\Models\User\UserPlaces::where('country', null)->get();

    foreach ($places as $place) {
        $country = null;
        $url = "https://maps.googleapis.com/maps/api/place/details/json?key=" . getenv('GOOGLE_MAP_KEY') . "&place_id={$place->rawId}&fields=address_components";

        $response = json_decode(file_get_contents($url), true);
        if ($address = ($response['result']['address_components'] ?? null)) {

            foreach ($address as $item) {
                if (in_array('country', $item['types'])) {
                    $country = $item['long_name'];
                }
            }

            $place->country = $country;
            $place->save();
            echo "{$place->name_en} - {$country}\n";
        } else {
            print_r([$response, $url, $place]);
        }
    }
});

Artisan::command('test-bp-tg', function () {
    foreach([1945, 1911, 1852, 1749, 1368, 451, 295, 253] as $bp_id) {
        $bp_profile = \App\Models\User\User::where('id', $bp_id)->first()->profile;

        try {
            $ping = \Telegram\Bot\Laravel\Facades\Telegram::getChat([
                'chat_id' => $bp_profile->telegram_id
            ]);
            print_r($bp_profile->first_name . ' ' . $bp_profile->last_name . ' ' . $ping->id);
        } catch (Exception $e) {
            print_r($bp_profile->first_name . ' ' . $bp_profile->last_name . ' редиска и отключил(-a) бота' );
        }

        print_r("\n");
    }
})->describe('Test if bp\'s have telegram connected');

Artisan::command('manage-media-folder', function () {
    $files = array_diff(scandir(public_path('media')), array('..', '.'));

    foreach($files as $file) {
        $file_name = pathinfo(public_path('media') . '/' . $file)['basename'];

        $mime = mime_content_type(public_path('media') . '/' . $file);

        if(strstr($mime, "video/")) {
            $file_mime = 'video';
        } else if(strstr($mime, "image/")) {
            $file_mime = 'image';
        } else if(strstr($mime, "audio/")) {
            $file_mime = 'audio';
        }

        $media = MspMedia::firstOrCreate([
            'path' => $file_name,
            'type' => $file_mime,
            'source' => 'file'
        ]);
    }
})->describe('Create records for all media files');

Artisan::command('over9000', function () {
    $links = file(storage_path('app/media') . '/samgiita_list.txt');

    foreach($links as $link) {
        $link = str_replace("\r\n", '', $link);

        $media = MspMedia::firstOrCreate([
            'path' => $link,
            'type' => 'audio',
            'source' => 'url'
        ]);

        $name = explode('/', $link);
        $number = explode('%20', $name[count($name)-1])[0];

        $samgit = \App\Samgit::where('id', $number)->first();

        if($samgit) {
            $samgit->media()->syncWithoutDetaching([$media->id],
            [
                'hiden' => true
            ]);
        }
    }
})->describe('Load all media and relations with samgiits from samgiit songs links list');

Artisan::command('users:give-unit-status', function () {
    $users = User::whereDoesntHave('statuses')->get();

    $status = \App\Status::where('name_en', 'Unit')->first();

    foreach($users as $user) {
        $user->statuses()->sync([$status->id]);
    }
})->describe('Give all users without statuses status \'unit\'');

Artisan::command('show-multiple-statuses', function () {
    $users = User::withCount('statuses')->get();

    foreach($users as $user) {
        if($user->statuses_count > 1) {
            print_r($user->id . "\n");
        }
    }
});

Artisan::command('unlimited-secretaries-works', function () {
    $units = \App\Models\Geolocation\Unit::whereNotNull('secretary_id')->get();

    $users = $units->pluck('secretary_id')->toArray();

    $secretary_title = \App\UnitTitle::where('slug', 'sunit')->first();

    foreach($units as $unit) {
        User::find($unit->secretary_id)->units()->updateExistingPivot($unit->id, [
            'title_id' => $secretary_title->id
        ]);
    }

    $secretary_role_id = \jeremykenedy\LaravelRoles\Models\Role::where('slug', 'secretary')->first()->id;

    $secretaries = User::whereHas('roles', function ($q) use ($secretary_role_id) {
        $q->where('role_id', $secretary_role_id);
    })->whereNotIn('id', $users)->get();

    foreach($secretaries as $secretary) {
        if(!$secretary->unit || !$secretary->unit->pivot->title_id) $secretary->roles()->detach($secretary_role_id);
    }
});

Artisan::command('audit-clear', function () {
    DB::table('audits')->whereDate('created_at', '<', \Carbon\Carbon::now()->subMonths(6))->delete();
});

Artisan::command('users:deprecate-roles', function () {
    $users = User::has('roles', '>', 1)->whereHas('profile')->where('registration_completed', true)->get();

    $sadhaka_id = \jeremykenedy\LaravelRoles\Models\Role::where('slug', 'sadhaka')->first();

    foreach($users as $user) {
        if($user->hasAllRoles(['sadhaka','margii'])) {
            $user->detachRole($sadhaka_id);
        }
    }
})->describe('Remove sadhaka from margiis');

Artisan::command('json-call-fuckery', function () {
    $call = \App\Call::create([
        'slug' => 'initiation',
        'name' => [
            'ru' => 'Инициация',
            'en' => 'Initiation',
            'uk' => 'Ініціація'
        ]
    ]);
});

Artisan::command('bankai', function() {
    $districts = \App\Models\Geolocation\District::where('country', null)->get();
    $key = getenv('GOOGLE_MAP_KEY');

    $requests = 0;
    $failures = [];

    foreach($districts as $district) {
        try{
            echo("Doing {$district->name}\n");

            $district_name = str_replace(' ', '%20', $district->name);

            $district_auto = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/place/autocomplete/json?key={$key}&input={$district_name}")) ?? null;

            if($district_auto->status === "OK") {
                $country = str_replace(' ', '%20', end($district_auto->predictions[0]->terms)->value);

                if(cache("place_auto:{$country}")) {
                    $country_auto = cache("place_auto:{$country}");
                } else {
                    $country_auto = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/place/autocomplete/json?key={$key}&input={$country}")) ?? null;
                    cache()->put("place_auto:$country", $country_auto, now()->addDay());
                    $requests++;
                }

                if($country_auto->status === "OK") {
                    if($country_auto->predictions[0]->types[0] === "country") {
                        $country_id = $country_auto->predictions[0]->place_id;

                        if(cache("place_details:{$country_id}:ru")) {
                            $country_details_ru = cache("place_details:{$country_id}:ru");
                        } else {
                            $country_details_ru = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/place/details/json?key={$key}&placeid={$country_id}&language=ru&fields=address_components")) ?? null;
                            cache()->put("place_details:{$country_id}:ru", $country_details_ru, now()->addDay());
                            $requests++;
                        }

                        if($country_details_ru && $country_details_ru->status === "OK") {
                            $country_name_ru = $country_details_ru->result->address_components[0]->long_name;
                        } else {
                            $country_name_ru = null;
                            $failures[] = $district->name;
                        }

                        if(cache("place_details:{$country_id}:en")) {
                            $country_details_en = cache("place_details:{$country_id}:en");
                        } else {
                            $country_details_en = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/place/details/json?key={$key}&placeid={$country_id}&language=en&fields=address_components")) ?? null;
                            cache()->put("place_details:{$country_id}:en", $country_details_en, now()->addDay());
                            $requests++;
                        }

                        if($country_details_ru && $country_details_ru->status === "OK") {
                            $country_name_en = $country_details_en->result->address_components[0]->long_name;
                        } else {
                            $country_name_en = null;
                            if(end($failures) !== $district->name) $failures[] = $district->name;
                        }

                        $district->update([
                            'country' => [
                                'en' => $country_name_en,
                                'ru' => $country_name_ru
                            ]
                        ]);
                        echo("{$district->name} is in {$country_name_en} or {$country_name_ru}\n\n");
                    } else {
                        echo("{$district->name} is... not in a country?... ffs\n\n");
                        $failures[] = $district->name;
                    }
                } else {
                    echo("{$district->name} failed on country auto\n\n");
                    $failures[] = $district->name;
                }
            } else {
                echo("{$district->name} failed on its auto\n\n");
                $failures[] = $district->name;
            }
        } catch (Exception $e) {
            echo("{$district->name} is a failure\n\n");
            if(end($failures) !== $district->name) $failures[] = $district->name;
        }
    }

    echo("{$requests} requests made\n\n");
    echo("Failures:\n");
    print_r($failures);
});

Artisan::command('unlimited-bps-works', function () {
    $districts = \App\Models\Geolocation\District::whereNotNull('bp_id')->get();

    foreach($districts as $district) {
        $bp = User::find($district->bp_id);

        if($bp) {
            $district->bps()->syncWithoutDetaching([$bp->id]);
            $district->update([
                'bp_id' => null
            ]);
        }
    }

    print_r("Job's done\n");
})->describe('Transfer BPs to a new relations system');
