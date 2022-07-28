<?php

namespace App;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Samgit extends BaseModel
{
    protected $fillable = [
        'transcription_en',
        'translation_en',
        'daymonth',
        'mp3',
        'title',
        'transcription_ru',
        'translation_ru',
        'translation_uk',
        'transcription_uk',
        'premium',
        'samgiita_number',
        'samgiita_date',
        'title_en',
        'title_ru',
        'title_uk',
        'samgiita_theme',
        'samgiita_lyrics',
        'samgiita_music',
        'sarkarverse_number',
        'sarkarverse_date',
        'sarkarverse_title',
        'sarkarverse_theme',
        'sarkarverse_lyrics',
        'sarkarverse_music'
    ];

    protected $casts = [
        'mp3' => 'array',
        'premium' => 'boolean'
    ];

    public function media()
    {
        return $this->belongsToMany(MspMedia::class, 'samgits_media', 'samgit_id', 'media_id');
    }
}
