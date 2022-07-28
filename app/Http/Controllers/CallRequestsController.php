<?php

namespace App\Http\Controllers;

use App\Call;
use App\CallRequest;
use App\Http\Requests\NewCallRequest;
use App\Http\Resources\CallRequestsResource;
use App\Http\Resources\CallsResource;
use App\Http\Resources\UserIdDisplayNameResource;
use App\Http\Traits\HistoryTrait;
use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use jeremykenedy\LaravelRoles\Models\Role;

class CallRequestsController extends Controller
{
    use HistoryTrait;

    public function index()
    {
        $requests = CallRequest::query();

        $total = CallRequest::all()->count();

        $this->applyUserFilters($requests);

        $filtered = $requests->count();

        $requests = $requests->skip(request('skip'))->take(request('take'))->get();

        return CallRequestsResource::collection($requests)->additional([
            'meta' => [
                'total' => $total,
                'filtered' => $filtered,
                'calls' => CallsResource::collection(Call::all()),
                'curators' => UserIdDisplayNameResource::collection(User::whereHas('roles', function ($query) {
                    $query->where('roles.id', Role::where('slug', 'curator')->first()->id);
                })->get())
            ]
        ]);
    }

    public function save(NewCallRequest $request) {

        $user = auth()->user();
        $call = Call::where('slug', request('call'))->first();

        $call_request = CallRequest::create([
            'user_id' => $user->id,
            'call_id' => $call->id,
            'date' => request('date', '01.01.2000') . ' ' . explode('-', request('time', '00:00'))[0] . ':00',
            'user_phone' => request('phone'),
            'user_messenger' => request('messenger')
        ]);

        $this->saveHistoryLog('call-request-open', $call_request);

        return [
            'status' => 'ok'
        ];
    }

    public function edit()
    {
        $call = request('data');

        $request = CallRequest::where('id', $call['id'])->firstOrFail()->fill([
            'user_phone' => $call['user_phone'],
            'user_messenger' => $call['user_messenger'],
            'description' => $call['description'],
            'closed' => $call['closed'],
            'closed_status' => $call['closed_status'],
            'closed_notes' => $call['closed_notes']
        ]);

        if(!$request->getOriginal()['closed'] && $request->closed) {
            $request->fill([
                'closed_date' => Carbon::now(),
                'closed_id' => auth()->user()->id
            ]);

            $this->saveHistoryLog('call-request-close', $request, $request->getOriginal());
        } else {
            $this->saveHistoryLog('call-request-edit', $request, $request->getOriginal());
        }

        $request->save();

        return [
            'status' => '10 ramen out of 4'
        ];
    }

    public function accept()
    {
        $request_id = request('id');

        $request = CallRequest::where('id', $request_id)->firstOrFail()->fill([
            'host_id' => auth()->user()->id
        ]);

        $this->saveHistoryLog('call-request-edit-accept', $request, $request->getOriginal());

        $request->save();

        return [
            'status' => 'I got your number'
        ];
    }

    public function close()
    {
        $request_id = request('request_id');
        $status = request('status');

        $request = CallRequest::where('id', $request_id)->firstOrFail()->fill([
            'closed' => true,
            'closed_status' => $status,
            'closed_date' => Carbon::now()->toDateTimeString(),
            'closed_id' => auth()->user()->id
        ]);

        $this->saveHistoryLog('call-request-close', $request, $request->getOriginal());

        $request->save();

        /*if((Call::find($request->call_id)->slug === 'adequate-1') && $status === 'fail') {
            $user = User::find($request->user_id)
        }*/

        return [
            'status' => 'The prophecy is true'
        ];
    }

    public function forward()
    {
        $request_id = request('request_id');
        $curator_id = request('curator_id');

        $request = CallRequest::where('id', $request_id)->firstOrFail()->fill([
            'host_id' => $curator_id
        ]);

        $this->saveHistoryLog('call-request-edit-forward', $request, $request->getOriginal());

        $request->save();

        return [
            'status' => 'Not my fault'
        ];
    }

    protected function applyUserFilters(&$requests)
    {
        $requests->where('call_requests.call_id', Call::where('slug', 'adequate-1')->first()->id)->where('host_id', null)->orWhere('host_id', auth()->user()->id);

        if($id = request('id')) {
            $requests->where('call_requests.id', $id);
        }

        if ($name = request('name')) {
            $requests->whereHas('user.profile', function ($query) use ($name) {
                $query->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', "%$name%")
                    ->orWhere('spiritual_name', 'like', "%$name%");
            });
        }

        if ($call_type = json_decode(request('call_type'))) {
            $requests->where('call_requests.call_id', $call_type->id);
        }

        if ($phone = request('phone')) {
            $requests->where('call_requests.user_phone', 'like', "%$phone%");
        }

        if ($messenger = request('messenger')) {
            $requests->where('call_requests.user_messenger', $messenger);
        }

        if ($closed = request('closed')) {
            $requests->where('call_requests.closed', $closed === 'true');
        }

        if($status = request('status')) {
            $requests->where('closed_status', $status);
        }

        switch (request('sortBy')) {
            /*case 'name':
                $requests->join('user_profiles', 'users.id', '=', 'user_profiles.user_id')
                    ->orderBy('user_profiles.first_name', request('sortOrder', 'desc'))
                    ->orderBy('user_profiles.last_name', request('sortOrder', 'desc'));
                break;*/
            default:
                $requests->orderBy('call_requests.created_at', request('sortOrder', 'desc'));
        }
    }
}
