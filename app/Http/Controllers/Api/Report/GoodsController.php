<?php

namespace App\Http\Controllers\Api\Report;

use App\Good;
use App\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoodsController extends Controller
{
    public function store(Request $request, $reportId)
    {
        Good::create(
            array(
                'user_id' => $request->user()->id,
                'report_id' => $reportId
            )
        );


        $report = Report::findOrFail($reportId);
        $good = $report->goods()->where('user_id', auth()->user()->id)->first();

        return ['report' => $report, 'good' => $good];
    }
    public function destroy($reportId, $goodId) {
        $report = Report::findOrFail($reportId);
        $report->good_by()->findOrFail($goodId)->delete();
        $report = Report::findOrFail($reportId);

        return $report;
    }
}
