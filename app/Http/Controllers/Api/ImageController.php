<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        $image = Image::make($request->image);
        $fileName = 'sample.png';
        $filePath = public_path() . '/img/';
        $image->save($filePath . $fileName);
    }
}
