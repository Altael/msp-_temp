<?php

namespace App\Http\Controllers;

use App\Aharya;
use App\Asanas;
use App\DailyPractice;
use App\DailyReward;
use App\Dharmacakra;
use App\Fasting;
use App\Fullbath;
use App\Halfbath;
use App\Http\Resources\DailyPracticeRanksDisplayResource;
use App\Http\Resources\DailyRewardsResource;
use App\Http\Resources\FastingsResource;
use App\Http\Resources\PracticeInfoResource;
use App\Models\User\User;
use App\Models\User\UserTeachers;
use App\Pancajania;
use App\PracticesInfo;
use App\Upavasa;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use App\PracticeRank;
use App\PracticePoint;
use App\Http\Resources\DailyPracticeRanksResource;
use App\Http\Resources\DailyPracticePointsResource;
use App\Http\Resources\DailyPracticeResource;
use Psy\Util\Json;

class DailyPracticesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (request()->exists('lists')) {
            return $this->lists();
        }

        if (request()->exists('practices')) {
            return $this->practices();
        }

        if (request()->exists('fasting')) {
            return $this->fasting(request('date'));
        }

        if (request()->exists('dharmacakra')) {
            return $this->dharmacakra(request('date'));
        }

        if (request()->exists('reward')) {
            return $this->reward(request('date'));
        }

        if(request()->exists('alt')) {
            return $this->amDiary(request('date'));
        }

        if(request()->exists('info')) {
            return $this->info(request('practice'));
        }

        if(request()->exists('streak')) {
            return $this->streak();
        }

        if(request()->exists('community')) {
            return $this->community(request('date'));
        }

        $userId = request('user', auth()->user()->id);
        $user = User::where('id', $userId)->firstOrFail();
        $foreignUser = false;

        if(request()->exists('user') && (int)request('user') !== auth()->user()->id) {
            $agree = $user->profile->acarya_diary;
            $isTeacher = $user->getTeacherAttribute()->id === auth()->user()->id ? true : false;

            if(!$agree || !$isTeacher) {
                return [
                    'status' => 'bad'
                ];
            }

            $foreignUser = true;
        }

        $take = request('take', 50);
        $skip = request('skip', 0);
        $practices = $user->dailyPractices()
            ->take($take)
            ->skip($skip)
            ->orderBy('date', 'desc')
            ->get();

        $dates = $user->dailyPractices()
            ->pluck('date');

        return [
            'status' => 'ok',
            'items' => $practices,
            'meta' => [
                'total' => $user->dailyPractices()->count(),
                'name' => $user->displayName,
                'foreign' => $foreignUser,
                'doneDates' => $dates
            ],
        ];
    }

    public function amDiary($date) {
        $user = auth()->user();
        $userId = $user->id;

        $date = Carbon::createFromDate($date);

        $practices = [];

        $periodStart = new Carbon($date->startOfMonth());
        $periodEnd = new Carbon($date->endOfMonth());

        $dates = CarbonPeriod::create($periodStart, $periodEnd);

        foreach ($dates as $day) {
            $practices[$day->toDateString()] = $user->dailyPractices()->where('date', $day)->latest()->first();
        }

        return [
            'items' => array_reverse($practices),
            'meta' => [
                'name' => $user->displayName,
                'sex' => $user->profile->sex,
                'mobile_connected' => isset($user->mobile_id),
                'difficulty' => $user->profile->practices_diff
            ],
        ];
    }

    public function streak()
    {
        $streak = 0;

        $diaries = DailyPractice::where('user_id', auth()->user()->id)->orderBy('date')->get();
        $total = count($diaries);
        $currentDay = Carbon::today();

        if($currentDay->diffInDays(Carbon::createFromDate($diaries[$total-1]->date)) < 2) {
            for ($i = $total - 1; $i > 0; $i--) {
                $today = Carbon::createFromDate($diaries[$i]->date);
                $yesterday = Carbon::createFromDate($diaries[$i - 1]->date);

                if ($today->diffInDays($yesterday) === 1) {
                    $streak++;
                } else if($today->diffInDays($yesterday) !== 0) {
                    break;
                }
            }
            $streak++;
        }

        return [
            'streak' => $streak
        ];
    }

    public function community($date)
    {

        $count = DailyPractice::where('date', $date)->where('user_id', '<>', auth()->user()->id)->count();

        if($compareDay = DailyPractice::where('user_id', auth()->user()->id)->where('date', $date)->first()) {
            $worseAmount = DailyPractice::where('date', $date)->where('points', '<', $compareDay->points)->where('user_id', '<>', auth()->user()->id)->count();
        }

        $success = $count ? $worseAmount * 100 / $count : 100;

        return [
            'community' => $count,
            'success' => $success
        ];
    }

    public function getAverageForUser()
    {
        $userId = auth()->user()->id;
        $user = User::where('id', $userId)->firstOrFail();
        $average_points = $user->dailyPractices()->pluck('points')->avg();

        return [
            'average_points' => $average_points
        ];
    }

    public function store()
    {
        $user = auth()->user();
        $item = request('item');

        if ($practice = $user->dailyPractices()->where('date', $item['date'])->first()) {
            $practice->update($item);
        } else {
            $user->dailyPractices()->create($item);
        }

        return [
            'status' => 'ok'
        ];
    }

    public function destroy($id)
    {
        $practice = auth()->user()->dailyPractices()->findOrFail($id);
        $practice->delete();

        return [
            'status' => 'ok'
        ];
    }

    protected function lists()
    {
        return [
            'asanaTitles' => DailyPractice::asanaTitles(),
            'pancajaniaTitles' => DailyPractice::pancajaniaTitles(),
            'vyapaka_shaocaTitles' => DailyPractice::vyapaka_shaocaTitles(),
            'full_bathTitles' => DailyPractice::full_bathTitles(),
            'aharyaTitles' => DailyPractice::aharyaTitles(),
            'dharmacakraTitles' => DailyPractice::dharmacakraTitles(),
            'upavasaTitles' => DailyPractice::upavasaTitles(),
            'practiceTitles' => DailyPractice::practiceTitles()
        ];
    }

    protected function practices()
    {
        $pointItems = PracticePoint::all();
        $points = [];
        foreach ($pointItems as $point){
            $points[$point['name']] = new DailyPracticePointsResource($point);
        }

        $maximum_points = [
                'meditation' => $points['meditation']['points'] + $points['meditation_time']['points'],
                'lalita_marmika' => $points['lalita_marmika']['points'] + $points['lalita_marmika_time']['points'],
                'karma_yoga' => $points['karma_yoga']['points'],
                'dances' => $points['dances']['points'],
                'svadhyaya' => $points['svadhyaya']['points'],
                'diary' => $points['diary']['points']
        ];

        $practiceItems = Aharya::all();
        $aharya = [];
        foreach ($practiceItems as $item){
            $aharya[$item['name']] = new DailyPracticeResource($item);
        }

        $maximum_points['aharya'] = max(array_column($aharya, 'points'));

        $practiceItems = Asanas::all();
        $asanas = [];
        foreach ($practiceItems as $item){
            $asanas[$item['name']] = new DailyPracticeResource($item);
        }

        $maximum_points['asanas'] = max(array_column($asanas, 'points'));

        $practiceItems = Dharmacakra::all();
        $dharmacakra = [];
        foreach ($practiceItems as $item){
            $dharmacakra[$item['name']] = new DailyPracticeResource($item);
        }

        $maximum_points['dharmacakra'] = max(array_column($dharmacakra, 'points'));

        $practiceItems = Fullbath::all();
        $fullbath = [];
        foreach ($practiceItems as $item){
            $fullbath[$item['name']] = new DailyPracticeResource($item);
        }

        $maximum_points['fullbath'] = max(array_column($fullbath, 'points'));

        $practiceItems = Halfbath::all();
        $halfbath = [];
        foreach ($practiceItems as $item){
            $halfbath[$item['name']] = new DailyPracticeResource($item);
        }

        $maximum_points['halfbath'] = max(array_column($halfbath, 'points'));

        $practiceItems = Pancajania::all();
        $pancajania = [];
        foreach ($practiceItems as $item){
            $pancajania[$item['name']] = new DailyPracticeResource($item);
        }

        $maximum_points['pancajania'] = max(array_column($pancajania, 'points'));

        $practiceItems = Upavasa::all();
        $upavasa = [];
        foreach ($practiceItems as $item){
            $upavasa[$item['name']] = new DailyPracticeResource($item);
        }

        $maximum_points['upavasa'] = max(array_column($upavasa,'points'));

        $maximum_points['total'] = array_sum($maximum_points);

        return [
            'ranks' => DailyPracticeRanksDisplayResource::collection(PracticeRank::all()),
            'points' => $points,
            'aharya' => $aharya,
            'asanas' => $asanas,
            'dharmacakra' => $dharmacakra,
            'fullbath' => $fullbath,
            'halfbath' => $halfbath,
            'pancajania' => $pancajania,
            'upavasa' => $upavasa,
            'practices' => $maximum_points
        ];
    }

    protected function fasting($date) {
        $fasting = Fasting::latest('date')->whereDate('date', '<=', $date)->where('type', 'ekadashi')->first()->date;
        if($fasting === $date) return 2;
        $fasted = optional(DailyPractice::where('user_id', auth()->user()->id)->where('date', $fasting)->first())->upavasa;
        return $fasted ?? 'no';
    }

    protected function dharmacakra($date) {
        $last = DailyPractice::where('user_id', '=', auth()->user()->id)->whereDate('date', '<=', $date)->where('dharmacakra', '<>', 'no')->latest('date')->first(['date', 'dharmacakra']);

        return [
            'status' => $last ? 'ok' : 'empty',
            'lastDC' => $last
        ];
    }

    protected function reward($date) {
        $quote = DailyReward::where('date', $date)->where('type', 'quote')->first() ? new DailyRewardsResource(DailyReward::where('date', $date)->where('type', 'quote')->first()) : new DailyRewardsResource(DailyReward::where('type', 'quote')->where('default', true)->first());
        $story = DailyReward::where('date', $date)->where('type', 'story')->first() ? new DailyRewardsResource(DailyReward::where('date', $date)->where('type', 'story')->first()) : new DailyRewardsResource(DailyReward::where('type', 'story')->where('default', true)->first());

        return [
            'quote' => $quote,
            'story' => $story
        ];
    }

    protected function info($practice) {
        return [
            'practiceInfo' => PracticesInfo::where('slug', $practice)->first() ? new PracticeInfoResource(PracticesInfo::where('slug', $practice)->first()) : null
        ];
    }
}
