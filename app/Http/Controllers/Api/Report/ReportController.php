<?php

namespace App\Http\Controllers\Api\Report;

use App\Http\Resources\UserResource;
use App\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class ReportController extends Controller
{
    public function index()
    {
        $array = [];
        $reports = Report::orderBy('created_at', 'desc')->paginate(15);
        foreach($reports as $report) {
            $good = $report->goods()->where('user_id', auth()->user()->id)->first();
            array_push($array,['report' => $report, 'good' => $good]);
        }
        return [
            'data' => $array,
            'meta' => Report::paginate()
        ];
    }

    public function myReport(Request $request)
    {
        $user = new UserResource($request->user());
        $reports = Report::all();
        $filtered = $reports->filter(function ($value) use($user) {
            return $value->user_id === $user->id;
        });
        $sorted = $filtered->sortByDesc('created_at');
        return $sorted->values()->all();
    }

    public function post(Request $request)
    {
        $this->validate($request, [
            'prefectures' => 'required',
            'address' => 'required'
        ]);


        $report = new Report();
        $report->size = $request->size;
        $report->prefectures = $request->prefectures;
        $report->address = $request->address;
        $report->description = $request->description;
        $report->user_id = $request->user()->id;
        $report->save();
        return $report->load('user');
    }

    public function show(int $id)
    {
        $report = Report::findOrFail($id);

        $good = $report->goods()->where('user_id', auth()->user()->id)->first();

        return ['report' => $report, 'good' => $good];
    }
}
