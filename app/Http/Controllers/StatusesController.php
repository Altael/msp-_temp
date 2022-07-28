<?php

namespace App\Http\Controllers;

use App\Http\Resources\UsersStatusesResource;
use App\MspSetting;
use App\Status;
use Illuminate\Http\Request;

class StatusesController extends Controller
{
    public function index() {
        $statuses = Status::query()->latest()->get();

        /*$unit_id = auth()->user()->unit->id;*/

        /*$settings = MspSetting::where('entity', 'unit')->where('entity_id', $unit_id)->firstOr(function () {
            return MspSetting::where('entity', 'msp')->first();
        });*/

        $settings = MspSetting::where('entity', 'msp')->first();

        return [
            'statuses' => $statuses,
            'settings' => $settings,
            'locale' => app()->getLocale()
        ];
    }

    public function save() {
        $status = request('status');

        if($status['id']) {
            Status::findOrFail($status['id'])->update($status);
        } else {
            if(!auth()->user()->hasRole('admin')) {
                $status['unit_id'] = auth()->user()->unit->id;
            }
            Status::create($status);
        }

        return [
            'status' => 'ok'
        ];
    }

    public function delete($id) {
        Status::findOrFail($id)->delete();

        return [
            'status' => 'ok'
        ];
    }
}
