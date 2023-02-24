<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SeriesFormRequest;
use App\Models\Series;
use Symfony\Component\HttpFoundation\Request;

class SeriesController extends Controller
{
    public function index()
    {
        return Series::all();
    }

    public function store(SeriesFormRequest $request)
    {
        $serie = Series::create($request->all());

        return response()->json($serie, 201);
    }

    public function show(Series $series)
    {
        return $series;
    }

    public function seasons(int $id)
    {
        $serie = Series::whereId($id)
            ->with('seasons.episodes')
            ->first();

        return $serie;
    }
}
