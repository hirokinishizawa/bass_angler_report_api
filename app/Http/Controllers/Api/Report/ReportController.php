<?php

namespace App\Http\Controllers\Api\Report;

use App\Http\Resources\UserResource;
use App\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::all();
        $sorted = $reports->sortByDesc('created_at');
        return $sorted->values()->all();
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
        return $report;
    }
}