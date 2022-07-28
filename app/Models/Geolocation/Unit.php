<?php

namespace App\Models\Geolocation;

use App\Models\BaseModel;
use App\Models\User\User;
use App\MspSetting;
use App\Program;
use App\UnitProgram;
use App\UnitTitle;
use Carbon\Carbon;
use Znck\Eloquent\Traits\BelongsToThrough;

class Unit extends BaseModel
{
    use BelongsToThrough;

    protected $fillable = [
        'district_area_id', 'name', 'secretary_id', 'notes', 'default_samgits', 'dc_transcription_lang', 'dc_main_lang', 'registration_status'
    ];

    protected $casts = [
        'default_samgits' => 'array'
    ];

    public function districtArea()
    {
        return $this->belongsTo(DistrictArea::class, 'district_area_id');
    }

    public function district()
    {
        return $this->belongsToThrough(District::class, DistrictArea::class);
    }

    public function acaryas()
    {
        return $this->belongsToMany(User::class, 'acarya_geo', 'geo_id', 'acarya_id')->withPivotValue('type', 'unit');
    }

    public function global_acaryas()
    {
        $unit_acaryas = $this->acaryas;
        $area_acaryas = $this->districtArea->acaryas;
        $district_acaryas = $this->districtArea->district->acaryas;
        $diocese_acaryas = $this->districtArea->district->diocese->acaryas;
        $region_acaryas = $this->districtArea->district->diocese->region->acaryas;
        $sector_acaryas = $this->districtArea->district->diocese->region->sector->acaryas;

        return $unit_acaryas->merge($area_acaryas)->merge($district_acaryas)->merge($diocese_acaryas)->merge($region_acaryas)->merge($sector_acaryas);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'unit_user', 'unit_id', 'user_id')->withPivot('title_id');
    }

    public function active_members()
    {
        $active_time = Carbon::now()->subDays($this->settings->active_member_quota)->toDateString();

        $ini = \DB::select('SELECT

COUNT(DISTINCT uup.user_id) AS active_users

FROM units u

JOIN units_programs up ON up.unit_id = u.id
JOIN users_units_programs uup ON up.id = uup.unit_program_id
JOIN meditation_lessons ml ON uup.user_id = ml.user_id

WHERE u.id = ?
AND up.date >= ?
AND ml.lesson_number = 1

GROUP BY u.id', [$this->id, $active_time]);

        $all = \DB::select('SELECT

COUNT(DISTINCT uup.user_id) AS active_users

FROM units u

JOIN units_programs up ON up.unit_id = u.id
JOIN users_units_programs uup ON up.id = uup.unit_program_id

WHERE u.id = ?
AND up.date >= ?

GROUP BY u.id', [$this->id, $active_time]);

        return [
            'ini' => $ini[0]->active_users ?? 0,
            'not_ini' => ($all[0]->active_users ?? 0) - ($ini[0]->active_users ?? 0)
        ];
    }

    public function active_members_custom($start, $end) {
        $ini = \DB::select('SELECT

COUNT(DISTINCT uup.user_id) AS active_users

FROM units u

JOIN units_programs up ON up.unit_id = u.id
JOIN users_units_programs uup ON up.id = uup.unit_program_id
JOIN meditation_lessons ml ON uup.user_id = ml.user_id

WHERE u.id = ?
AND up.date >= ?
AND up.date < ?
AND ml.lesson_number = 1

GROUP BY u.id', [$this->id, $start, $end]);

        $all = \DB::select('SELECT

COUNT(DISTINCT uup.user_id) AS active_users

FROM units u

JOIN units_programs up ON up.unit_id = u.id
JOIN users_units_programs uup ON up.id = uup.unit_program_id

WHERE u.id = ?
AND up.date >= ?
AND up.date < ?

GROUP BY u.id', [$this->id, $start, $end]);

        return [
            'ini' => $ini[0]->active_users ?? 0,
            'not_ini' => ($all[0]->active_users ?? 0) - ($ini[0]->active_users ?? 0)
        ];
    }

    public function secretary()
    {
        return $this->users()->where('title_id', UnitTitle::where('slug', 'sunit')->first()->id)->first();
    }

    public function officers()
    {
        return $this->users()->whereNotNull('title_id')->get()->merge($this->users()->has('roles', '>', 1)->get());
    }

    public function events()
    {
        return $this->hasMany(UnitProgram::class, 'unit_id');
    }

    public function getSettingsAttribute()
    {
        return MspSetting::where('entity', 'unit')->where('entity_id', $this->id)->firstOr(function () {
            return MspSetting::where('entity', 'msp')->first();
        });
    }
}
