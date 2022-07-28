<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserEditRolesResource;
use App\Models\Geolocation\Diocese;
use App\Models\Geolocation\District;
use App\Models\Geolocation\DistrictArea;
use App\Models\Geolocation\Region;
use App\Models\Geolocation\Sector;
use Illuminate\Support\Arr;
use jeremykenedy\LaravelRoles\Models\Role;
use Telegram\Bot\Laravel\Facades\Telegram;

class NotificationsController extends Controller
{
    public function index()
    {
        if (request()->exists('json')) {
            return [
                'status' => 'ok',
                'geo' => $this->getGeo(),
                'roles' => UserEditRolesResource::collection(Role::all())
            ];
        }

        return view('notifications.index');
    }

    public function store()
    {
        $message = request('message');

        $geo = $this->getGeo();
        $users = $geo->getTelegramUsersWithRoles(Arr::pluck($message['roles'], 'slug'));

        foreach ($users as $user) {
            Telegram::sendMessage([
                'chat_id' => $user->profile->telegram_id,
                'parse_mode' => 'html',
                'text' => $message['text']
            ]);
        }

        return [
            'status' => 'ok',
            'users' => $users->count()
        ];
    }

    protected function getGeo()
    {
        $typeMap = [
            'district_area' => DistrictArea::class,
            'district' => District::class,
            'diocese' => Diocese::class,
            'region' => Region::class,
            'sector' => Sector::class,
        ];

        $geo = null;

        $type = request('type');
        $item = request('item');

        if ($type && $item && ($class = $typeMap[$type] ?? null)) {
            $geo = $class::find($item);
        }

        return $geo;
    }

}
