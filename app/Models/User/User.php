<?php

namespace App\Models\User;

use App\Call;
use App\CallRequest;
use App\DailyPractice;
use App\HistoryEvent;
use App\Http\Resources\UnitTitlesResource;
use App\Models\Geolocation\Diocese;
use App\Models\Geolocation\District;
use App\Models\Geolocation\DistrictArea;
use App\Models\Geolocation\Unit;
use App\Models\MeditationLessons\MeditationLessons;
use App\Models\Questions\QuestionMessages;
use App\Models\Questions\Questions;
use App\MspSetting;
use App\Samgit;
use App\Services\MeditationLessons\MeditationLessonsService;
use App\Status;
use App\UnitProgram;
use App\UnitTitle;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasRoleAndPermission;
    use SoftDeletes;
    use SoftCascadeTrait;
    use HasRelationships;

    protected $fillable = [
        'id',
        'district_area_id',
        'name',
        'email',
        'password',
        'registration_completed',
        'language',
        'hidden',
        'notes',
        'notify_name',
        'mobile_id',
        'fake',
        'sadvipra',
        'lft',
        'registration_platform'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $softCascade = ['socials'];

    public function hasSuperRole()
    {
        return !empty(array_filter($this->roles()->pluck('slug')->toArray(), function ($role) {return $role !== 'sadhaka' && $role !== 'margii';}));
    }

    public function units()
    {
        return $this->belongsToMany(Unit::class, 'unit_user', 'user_id', 'unit_id')->withPivot('title_id');
    }

    public function dioceses()
    {
        return $this->belongsToMany(Diocese::class, 'curator_diocese', 'user_id', 'diocese_id');
    }

    public function getUnitAttribute()
    {
        return $this->units->first();
    }

    public function getTitleAttribute()
    {
        return $this->belongsToMany(Unit::class, 'unit_user', 'user_id', 'unit_id')->withPivot('title_id')->first() ? new UnitTitlesResource(UnitTitle::find($this->belongsToMany(Unit::class, 'unit_user', 'user_id', 'unit_id')->withPivot('title_id')->first()->pivot->title_id)) : null;
    }

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'users_teachers', 'user_id', 'teacher_user_id');
    }

    public function profile()
    {
        return $this->HasOne(UserProfile::class, 'user_id');
    }

    public function bpDistricts()
    {
        return $this->belongsToMany(District::class, 'district_user', 'user_id', 'district_id');
    }

    public function bpUnits()
    {
        return $this->hasManyDeep(
        Unit::class,
        ['district_user', District::class, DistrictArea::class],
        ['user_id', 'id', 'district_id', 'district_area_id'],
        ['id', 'district_id', 'id', 'id']);
    }

    public function districtArea()
    {
        return $this->belongsTo(DistrictArea::class, 'district_area_id');
    }

    public function acaryas()
    {
        return $this->belongsToMany(User::class, 'acarya_helper', 'helper_id', 'acarya_id');
    }

    public function socials()
    {
        return $this->hasMany(UserSocials::class, 'user_id');
    }

    public function helpers()
    {
        return $this->belongsToMany(User::class, 'acarya_helper', 'acarya_id', 'helper_id');
    }

    public function questionMessages()
    {
        return $this->hasMany(QuestionMessages::class, 'user_id');
    }

    public function questions()
    {
        return $this->hasMany(Questions::class, 'from_user_id');
    }

    public function answers()
    {
        return $this->hasMany(Questions::class, 'to_user_id');
    }

    public function isRegistrationCompleted(): bool
    {
        return (bool)$this->registration_completed;
    }

    public function getId(): int
    {
        return (int)$this->id;
    }

    public function getTeacherAttribute()
    {
        return $this->teachers->first();
    }

    public function getNameAttribute($value)
    {
        return app()->getLocale() === 'en' ? \Str::ascii($value) : $value;
    }

    public function getDisplayNameAttribute()
    {
        if ($this->profile) {
            return $this->profile->displayName;
        }

        return $this->name;
    }

    public function lessons()
    {
        return $this->hasMany(MeditationLessons::class, 'user_id');
    }

    public function currentLesson()
    {
        return $this->hasOne(MeditationLessons::class, 'user_id')->latest('lesson_number');
    }

    public function getUnreadMessageCountAttribute()
    {
        $ids = $this->questions->pluck('id')->merge($this->answers->pluck('id'));

        return QuestionMessages::whereIn('question_id', $ids)
            ->where('user_id', '!=', $this->id)->where('status', 0)->count();
    }

    public function dailyPractices()
    {
        return $this->hasMany(DailyPractice::class, 'user_id');
    }

    public function amAllowed()
    {
        return $this->lessons()->count() || !(request()->root() === env('AM_URL'));
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'blog_etc_user_likes', 'user_id', 'post_id');
    }

    public function events()
    {
        return $this->belongsToMany(UnitProgram::class, 'users_units_programs', 'user_id', 'unit_program_id');
    }

    public function samgits()
    {
        return $this->belongsToMany(Samgit::class, 'favorite_users_samgits', 'user_id', 'samgit_id');
    }

    public function getSettingsAttribute()
    {
        $entity_id = [
            'msp' => null,
            'unit' => $this->units->first() ? $this->units->first()->id : null,
            'user' => $this->id
        ];

        $settings = MspSetting::where('entity', 'user')->where('entity_id', $entity_id['user'])->firstOr(function () use ($entity_id) {
            return MspSetting::where('entity', 'unit')->where('entity_id', $entity_id['unit'])->firstOr(function () {
                return MspSetting::where('entity', 'msp')->first();
            });
        });

        return $settings;
    }

    public function statuses()
    {
        return $this->belongsToMany(Status::class, 'users_statuses', 'user_id', 'status_id');
    }

    public function getStatusAttribute() {
        return $this->statuses()->first();
    }

    public function getAccessedRolesAttribute() {
        $user_roles = $this->roles()->get();

        $user_perms = [];

        foreach($user_roles as $role) {
            $role->mergeCasts(['accessed' => 'json']);

            if($role_perms = $role->accessed) $user_perms = array_merge($user_perms, $role_perms);
        }

        $user_perms = array_unique($user_perms);

        return Role::whereIn('roles.id', $user_perms)->get();
    }

    public function givenLessons() {
        return $this->hasMany(MeditationLessons::class, 'from_user_id');
    }

    public function historyEvents()
    {
        return $this->hasMany(HistoryEvent::class, 'user_id');
    }

    public function callRequests()
    {
        return $this->hasMany(CallRequest::class, 'user_id')->where('closed', false);
        /*return $this->hasMany(CallRequest::class, 'user_id')->where('closed', false)->whereDate('date', '>=', Carbon::now());*/
    }
}
