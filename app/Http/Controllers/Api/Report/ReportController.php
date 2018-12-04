<?php

namespace App\Http\Controllers\Api\Report;

use App\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function index(Report $report)
    {
        return $report;
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
