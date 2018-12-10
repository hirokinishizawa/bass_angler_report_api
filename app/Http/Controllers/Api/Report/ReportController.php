<?php

namespace App\Http\Controllers\Api\Report;

use App\Http\Resources\UserResource;
use App\Report;
use App\User;
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

    public function goodRanking()
    {
        $array = [];
        $reports = Report::orderBy('goods_count', 'desc')->limit(4)->get();
        foreach($reports as $report) {
            $good = $report->goods()->where('user_id', auth()->user()->id)->first();
            array_push($array,['report' => $report, 'good' => $good]);
        }
        return $array;
    }

    public function myReport(Request $request)
    {
        $array = [];
        $user_id = auth()->user()->id;
        $reports = Report::where('user_id', $user_id)->orderBy('created_at', 'desc')->paginate(15);
        foreach($reports as $report) {
            $good = $report->goods()->where('user_id', auth()->user()->id)->first();
            array_push($array,['report' => $report, 'good' => $good]);
        }
        return [
            'data' => $array,
            'meta' => Report::paginate()
        ];
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
        $report->image_filename = $request->image_filename;
        $report->user_id = $request->user()->id;
        $report->save();

        $good = $report->goods()->where('user_id', auth()->user()->id)->first();

        return ['report' => $report->load('user'), 'good' => $good];
    }

    public function show(int $id)
    {
        $report = Report::findOrFail($id);

        $good = $report->goods()->where('user_id', auth()->user()->id)->first();

        return ['report' => $report, 'good' => $good];
    }

    public function upload(Request $request)
    {
        $params = $request->validate([
            'image_filename' => 'required|file|image|max:4000',
        ]);

        $file = $params['image_filename'];
        $image = \Image::make(file_get_contents($file->getRealPath()));
        $image->save(public_path().'/images/'.$file->hashName());

        return $file->hashName();
    }
}
