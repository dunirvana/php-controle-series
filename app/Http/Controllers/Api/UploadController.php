<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SeriesFormRequest;
use App\Models\Series;
use Symfony\Component\HttpFoundation\Request;

class UploadController extends Controller
{

    public function upload(Request $request)
    {
        $path = $request->query('path');

        $coverPath = $request->hasFile('file')
            ? $request->file('file')->store($path, 'public')
            : '';

        $statusCode = $coverPath !== '' ? 200 : 500;
        return response()->json($coverPath, $statusCode);
    }
}
