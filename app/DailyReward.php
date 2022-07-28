<?php

namespace App;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class DailyReward extends BaseModel
{
    protected $fillable = [
        'date',
        'title_en',
        'title_ru',
        'source_en',
        'source_ru',
        'en',
        'ru',
        'author_en',
        'author_ru',
        'audio_author_en',
        'audio_author_ru',
        'record_date_en',
        'record_date_ru',
        'place_en',
        'place_ru',
        'type',
        'audio',
        'uk',
        'author_uk',
        'title_uk',
        'source_uk',
        'audio_author_uk',
        'place_uk',
        'record_date_uk',
        'audio_ru',
        'audio_en',
        'audio_uk',
        'en_comentary_seju_en',
        'en_comentary_seju_ru',
        'en_comentary_seju_uk',
        'ru_comentary_seju_en',
        'ru_comentary_seju_ru',
        'ru_comentary_seju_uk',
        'uk_comentary_seju_en',
        'uk_comentary_seju_ru',
        'uk_comentary_seju_uk',
        'original_comentary_lang',
        'ru_translator_en',
        'ru_translator_ru',
        'ru_translator_uk',
        'uk_translator_en',
        'uk_translator_ru',
        'uk_translator_uk'
    ];

    protected $dates = ['date'];

    public function media()
    {
        return $this->belongsToMany(MspMedia::class, 'daily_rewards_media', 'reward_id', 'media_id')->withPivot('lang');
    }
}
