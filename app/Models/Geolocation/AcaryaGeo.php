<?php

namespace App\Models\Geolocation;

use App\Models\AuditModel;
use App\Models\BaseModel;

class AcaryaGeo extends AuditModel
{
    protected $fillable = ['acarya_id', 'geo_id', 'type'];
}
