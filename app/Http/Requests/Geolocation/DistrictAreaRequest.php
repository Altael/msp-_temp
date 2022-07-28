<?php

namespace App\Http\Requests\Geolocation;

use Illuminate\Foundation\Http\FormRequest;

class DistrictAreaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'districtId' => 'required|integer',
            'name' => 'required|max:255',
            'placeId' => 'required|max:255',
            'type' => 'required|in:city,region,country'
        ];
    }
}
