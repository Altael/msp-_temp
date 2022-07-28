<?php

namespace App;

use App\Models\BaseModel;
use App\Models\Geolocation\Unit;
use Illuminate\Database\Eloquent\Model;

class UnitProgram extends BaseModel
{
    protected $table = 'units_programs';

    protected $fillable = [
        'date',
        'unit_id',
        'program_id',
        'initiated_guests',
        'not_initiated_guests'
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function users()
    {
        return $this->belongsToMany(\App\Models\User\User::class, 'users_units_programs', 'unit_program_id', 'user_id');
    }
}
