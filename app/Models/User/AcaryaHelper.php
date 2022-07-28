<?php

namespace App\Models\User;

use App\Models\AuditModel;
use App\Models\BaseModel;

class AcaryaHelper extends AuditModel
{
    protected $table = 'acarya_helper';

    protected $fillable = ['acarya_id', 'helper_id'];
}
