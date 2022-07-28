<?php

namespace App\Http\Controllers;

use App\Repositories\Handbooks\SpiritualNamesRepository;
use App\SpiritualName;
use Illuminate\Http\Request;

class SpiritualNamesController extends Controller
{

    public function index(SpiritualNamesRepository $repository)
    {
        $names = $repository->getAll(request('skip', 0), request('take', 10));

        $total = $repository->getCount();

        return [
            'names' => $names,
            'total' => $total
        ];
    }

    public function store()
    {
        $item = request('name');

        if ($item['id'] !== null) {
            $name = SpiritualName::where('id', $item['id']);
            $name->update($item);
        } else {
            SpiritualName::create($item);
        }

        return [
            'status' => 'ok'
        ];
    }

    public function destroy($id)
    {
        $name = SpiritualName::where('id', $id);
        $name->delete();

        return [
            'status' => 'ok'
        ];
    }
}
