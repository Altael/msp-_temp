<?php

namespace App;

use App\Models\BaseModel;
use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;

class DailyPractice extends BaseModel
{
    use Notifiable;
    use HasRoleAndPermission;

    protected $fillable = [
        'user_id',
        'date',
        'diary',
        'diary_text',
        'guru_sakash',
        'phone_sakash',
        'oaths',
        'guru_mantra',
        'pancajania',
        'meditation_count',
        'meditation_time',
        'lalita_marmika_count',
        'lalita_marmika_time',
        'asanas',
        'kaosiki_count',
        'kaosiki_time',
        'tandava_count',
        'tandava_time',
        'vyapaka_shaoca',
        'full_bath',
        'svadhyaya',
        'karma_yoga',
        'aharya',
        'dharmacakra',
        'upavasa',
        'points',
        'rank',
        'pj_nulify',
        'meditation_nulify',
        'kiirtan_nulify',
        'asana_nulify',
        'kaosiki_nulify',
        'tandava_nulify',
        'hb_nulify',
        'fb_nulify',
        'sva_nulify',
        'karma_nulify',
        'food_nulify',
        'dc_nulify',
        'fast_nulify'
    ];

    protected $dates = ['date'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    static public function pancajaniaTitles($value = null) {
        $values = [
            'yes' => __('Yes'),
            'yes_and_sleep' => __('Yes, but took a nap'),
            'no' => __('No')
        ];

        return $values[$value] ?? $values;
    }
    static public function asanaTitles($value = null) {
        $values = [
            'morning' => __('Morning'),
            'morning_and_evening' => __('Twice'),
            'evening' => __('Evening'),
            'no' => __('No'),
            'period' => __('Period')
        ];

        return $values[$value] ?? $values;
    }
    static public function vyapaka_shaocaTitles($value = null) {
        $values = [
            'before_any' => __('Before eating, sadhana or sleeping'),
            'before_all' => __('Before everything'),
            'before_sadhana_and_eat_or_sleep' => __('Before sadhana and either eating or sleeping'),
            'no' => __('No'),
        ];

        return $values[$value] ?? $values;
    }
    static public function full_bathTitles($value = null) {
        $values = [
            'warm' => __('Warm'),
            'cold' => __('Cold'),
            'contrast' => __('Contrast'),
            'no' => __('No'),
        ];

        return $values[$value] ?? $values;
    }
    static public function aharyaTitles($value = null) {
        $values = [
            'sattva_norm' => __('Sattvika'),
            'sattva_much' => __('Sattvika with overeaten'),
            'rajah' => __('Rajasika'),
            'tamah' => __('Tamasika'),
            'no' => __('Fasting'),
        ];

        return $values[$value] ?? $values;
    }
    static public function dharmacakraTitles($value = null) {
        $values = [
            'participated' => __('Participated'),
            'had_duty' => __('Helped organize'),
            'no' => __('Didn\'t participate'),
        ];

        return $values[$value] ?? $values;
    }
    static public function upavasaTitles($value = null) {
        $values = [
            'dry' => __('Dry fasting'),
            'water' => __('Fasting with water'),
            'juices_fruits' => __('Fasting with juices and fruits'),
            'no' => __('No'),
        ];

        return $values[$value] ?? $values;
    }
    static public function practiceTitles($value = null) {
        $values = [
            'meditation' => __('Meditation'),
            'lalita_marmika' => __('Lalita Marmika'),
            'karma_yoga' => __('Karma Yoga'),
            'dances' => __('Yogic dances'),
            'svadhyaya' => __('Svadhyaya'),
            'diary' => __('Keeping a diary'),
            'aharya' => __('Nutrition'),
            'asanas' => __('Asanas'),
            'dharmacakra' => __('Dharmacakra'),
            'fullbath' => __('Full bath'),
            'halfbath' => __('Half bath'),
            'pancajania' => __('Pancajania'),
            'upavasa' => __('Fasting')
        ];

        return $values[$value] ?? $values;
    }
}
