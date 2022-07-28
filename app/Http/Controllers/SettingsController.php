<?php

namespace App\Http\Controllers;

use App\Http\Traits\HistoryTrait;
use App\MspSetting;

class SettingsController extends Controller
{
    use HistoryTrait;

    public function getSettings($entity) {
        $entity_id = request('id') ?
            [
                'msp' => null,
                'unit' => request('id'),
                'user' => request('id')
            ]
            :
            [
            'msp' => null,
            'unit' => count(auth()->user()->units) ? auth()->user()->units->first()->id : null,
            'user' => auth()->user()->id
        ];

        $settings = MspSetting::where('entity', $entity)->where('entity_id', $entity_id[$entity])->firstOr(function () use ($entity_id) {
            return MspSetting::where('entity', 'unit')->where('entity_id', $entity_id['unit'])->firstOr(function () {
                return MspSetting::where('entity', 'msp')->first();
            });
        });

        $settings->entity = $entity;
        $settings->entity_id = $entity_id[$entity];

        return [
            'settings' => $settings
        ];
    }

    public function postSettings($entity) {
        $request = request('settings');

        $settings = MspSetting::where('entity', $entity)->where('entity_id', $request['entity_id'])->first();

        if($settings) {
            $settings->fill(
                [
                    'dc_main_lang' => $request['dc_main_lang'],
                    'dc_transcription_lang' => $request['dc_transcription_lang'],
                    'standard_samgiits_amount' => $request['standard_samgiits_amount'],
                    'standard_samgiits_list' => $request['standard_samgiits_list'],
                    'standard_samgiits_type' => $request['standard_samgiits_type'],
                    'active_member_quota' => $request['active_member_quota'],
                    'standard_statuses' => $request['standard_statuses']
                ]
            );
        } else {
            $settings = MspSetting::create(
                [
                'entity' => $request['entity'],
                'entity_id' => $request['entity_id'],
                'dc_main_lang' => $request['dc_main_lang'],
                'dc_transcription_lang' => $request['dc_transcription_lang'],
                'standard_samgiits_amount' => $request['standard_samgiits_amount'],
                'standard_samgiits_list' => $request['standard_samgiits_list'],
                'standard_samgiits_type' => $request['standard_samgiits_type'],
                'active_member_quota' => $request['active_member_quota'],
                'standard_statuses' => $request['standard_statuses']
                ]
            );
        }

        $this->saveHistoryLog('changed-settings-unit', $settings, $settings->wasRecentlyCreated ? null : $settings->getOriginal());

        $settings->save();

        return [
            'status' => 'dead inside'
        ];
    }
}
