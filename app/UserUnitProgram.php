<?php

namespace App;

use App\Models\AuditModel;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class UserUnitProgram extends AuditModel
{
    protected $table = 'users_units_programs';

    protected $fillable = [
        'unit_program_id',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User\User::class, 'user_id');
    }

    public function unitProgram()
    {
        return $this->belongsTo(UnitProgram::class, 'unit_program_id');
    }
}
