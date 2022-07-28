<?php

namespace App\Models\User;

use App\Models\BaseModel;
use App\SpiritualName;
use Carbon\Carbon;

class UserProfile extends BaseModel
{

    protected $fillable = [
        'user_id',
        'first_name',
        'middle_name',
        'last_name',
        'sex',
        'profession',
        'phone',
        'acarya',
        'spiritual_name',
        'birthday',
        'email',
        'image',
        'place_id',
        'eula',
        'english',
        'news',
        'telegram_id',
        'acarya_diary',
        'hash_id',
        'practices_diff',
        'fasting',
        'dc_main_lang',
        'dc_transcription_lang',
        'telegram_nickname',
        'unit_alias',
        'phone_system',
        'email_system',
        'telegram_system',
        'hide_from_unit',
        'meditation_hours',
        'country',
        'region',
        'city'
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    protected $dates = [
        'birthday'
    ];

    public function getBirthdayAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    protected $appends = ['displayName', 'averageDiary', 'privateName'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function place()
    {
        return $this->belongsTo(UserPlaces::class, 'place_id', 'id');
    }

    /*public function spirituaName()
    {
        return $this->hasOne(SpiritualName::class, 'id', 'spiritual_name_id');
    }

    public function getSpiritualNameAttribute()
    {
        return $this->spiritualName()->first[app()->getLocale];
    }*/

    public function getNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getFirstNameAttribute($value)
    {
        return app()->getLocale() === 'en' ? \Str::ascii($value) : $value;
    }

    public function getLastNameAttribute($value)
    {
        return app()->getLocale() === 'en' ? \Str::ascii($value) : $value;
    }

    public function getDisplayNameAttribute(): string
    {
        if ($this->user && $this->user->hasRole('acarya')) {
            if($this->spiritual_name)
                $name = ($this->sex === 'male' ? 'Dada' : 'Didi') . " {$this->spiritual_name}";
            else
                $name = ($this->sex === 'male' ? 'Dada' : 'Didi') . " {$this->first_name} {$this->last_name}";

            if($this->ghost_acarya)
                $name = $name . " " . __("(not in system yet)");

            return $name;
        }

        $name = "";

        if($this->first_name || $this->last_name) {
            $name = "{$this->first_name} {$this->last_name}";

            if($this->spiritual_name && !$this->unit_alias){
                $name = "{$this->spiritual_name} (" . $name . ")";
            }

            if($this->unit_alias && !$this->spiritual_name) {
                $name = $name . " / {$this->unit_alias}";
            }

            if($this->spiritual_name && $this->unit_alias){
                $name = "{$this->spiritual_name} (" . $name . ") / {$this->unit_alias}";
            }
        } else {
            if($this->spiritual_name && !$this->unit_alias){
                $name = "{$this->spiritual_name}";
            }

            if($this->unit_alias && !$this->spiritual_name) {
                $name = "{$this->unit_alias}";
            }

            if($this->spiritual_name && $this->unit_alias){
                $name = "{$this->spiritual_name} / {$this->unit_alias}";
            }
        }


        return $name;
    }

    public function getPrivateNameAttribute(): string
    {
        if ($this->user && $this->user->hasRole('acarya')) {
            return $this->displayName;
        }

        return $this->first_name;
    }

    public function getAverageDiaryAttribute()
    {
        if($this->acarya_diary) {
            return $this->user->dailyPractices()->avg('points');
        }
    }


}
