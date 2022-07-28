<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function index($field)
    {
        $result = [];

        $dir = '../resources/lang';

        $cdir = scandir($dir);
        foreach ($cdir as $key => $value)
        {
            if (!in_array($value,array(".","..")))
            {
                if (!is_dir($dir . DIRECTORY_SEPARATOR . $value))
                {
                    $cut = strstr($value, '.');
                    $result[] = str_replace($cut, '', $value);
                }
            }
        }

        return [
            'locales' => $result,
            'locale' => auth()->user()->profile ? auth()->user()->profile[$field] : 'en'
        ];
    }

    public function set($table, $field, $locale)
    {
        $target = null;

        if ($table === "user_profiles") $target = auth()->user()->profile;
        if ($table === "units") $target = auth()->user()->unit;

        if($target) $target->update([
            $field => $locale
        ]);
    }
}
