<?php

namespace App\Http\Controllers;

use App\FavoriteUsersSamgits;
use App\Http\Resources\MantrasResource;
use App\Http\Resources\SamgitsResource;
use App\Mantra;
use App\MspSetting;
use App\Samgit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class    DharmacakraController extends Controller
{
    public function samgits()
    {
        $samgits = Samgit::query();

        $this->applyUserFilters($samgits);

        $samgits = $samgits->get();

        return [
            'samgiits' => SamgitsResource::collection($samgits)
        ];
    }

    public function mantras()
    {
        $mantras_list = [];

        switch(request('type')) {
            case "dc":
                $mantras_list = ['samgacchadvam', 'nityam_shudam', 'guru_puja', 'supreme_command', 'pranama'];
            break;
        }

        $items = MantrasResource::collection(Mantra::whereIn('slug', $mantras_list)->get());

        $mantras = [];

        foreach($items as $item) {
            $mantras[$item->slug] = $item;
        }

        return [
            'mantras' => $mantras
        ];
    }

    public function favorite($samgit_id) {
        $fav = FavoriteUsersSamgits::firstOrCreate([
            'user_id' => auth()->user()->id,
            'samgit_id' => $samgit_id
        ]);

        if($fav->wasRecentlyCreated) {
            return [
                'status' => 'liked'
            ];
        } else {
            $fav->delete();
            return [
                'status' => 'unliked'
            ];
        }
    }

    protected function applyUserFilters(&$samgiits) {
        if(request('today')) {
            if(request('date')) {
                $daymonth = request('date');
            } else {
                $daymonth = Carbon::now()->day . Carbon::now()->format('m');
            }

            $samgiits->where('daymonth', $daymonth)->orWhere('daymonth', '0' . $daymonth);
        }

        if(request('premium')) {
            $samgiits->where('premium', true);
        }

        if(request('favorites')) {
            $samgiits = auth()->user()->samgits();
        }

        if(request('random')) {
            $user = auth()->user();

            $entity_id = [
                'msp' => null,
                'unit' => $user->units->first() ? $user->units->first()->id : null
            ];

            $settings = MspSetting::where('entity', 'unit')->where('entity_id', $entity_id['unit'])->firstOr(function () {
                return MspSetting::where('entity', 'msp')->first();
            });

            if($settings->standard_samgiits_type === 'random') {
                srand(Carbon::now()->startOfWeek()->timestamp);
                $premium_samgiits = Samgit::where('premium', true)->pluck('id')->toArray();
                $samgiits->whereIn('id', array_rand(array_flip($premium_samgiits), $settings->standard_samgiits_amount));
            } else {
                $placeholders = implode(',',array_fill(0, count($settings->standard_samgiits_list), '?'));
                $samgiits->whereIn('id', $settings->standard_samgiits_list)
                    ->orderByRaw("field(id,{$placeholders})", $settings->standard_samgiits_list);
            }
        }

        if($filter = request('samgits')) {
            if(is_numeric($filter)) {
                $samgiits->where('id', $filter);
            } else {
                $samgiits->where('translation_en', 'like', "%$filter%")
                    ->orWhere('translation_ru', 'like', "%$filter%")
                    ->orWhere('translation_uk', 'like', "%$filter%")
                    ->orWhere('transcription_uk', 'like', "%$filter%")
                    ->orWhere('transcription_en', 'like', "%$filter%")
                    ->orWhere('transcription_ru', 'like', "%$filter%");
            }
        }
    }
}
