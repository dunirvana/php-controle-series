<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SeriesFormRequest;
use App\Models\Series;
use App\Repositories\SeriesRepository;
use Symfony\Component\HttpFoundation\Request;

class SeriesController extends Controller
{
    public function __construct(private SeriesRepository $seriesRepository)
    {

    }
    public function index(Request $request)
    {
        if (!$request->has('nome')) {
            return Series::all();
        }
        return Series::whereNome($request->nome)->get();

    }

    public function store(SeriesFormRequest $request)
    {
        $serie = $this->seriesRepository->add($request);

        return response()->json($serie, 201);
    }

    public function show(int $series)
    {
        $seriesModel = Series::find($series);
        if ($seriesModel === null) {
            return response()->json(['message' => 'Series not found'], 404);
        }

        return $seriesModel;
    }

    public function seasons(int $id)
    {
        $seriesModel = Series::with('seasons.episodes')->find($id);
        if ($seriesModel === null) {
            return response()->json(['message' => 'Series not found'], 404);
        }

        return $seriesModel;
    }

    public function episodes(int $id)
    {
        $seriesModel = Series::with('seasons.episodes')->find($id);
        if ($seriesModel === null) {
            return response()->json(['message' => 'Series not found'], 404);
        }

        return $seriesModel->episodes;
    }

    public function update(int $series, SeriesFormRequest $request)
    {
        //$series->fill($request->all());
        //$series->save();

        Series::where('id', $series)->update($request->all());

        return response('', 200);
    }

    public function destroy(int $serie)
    {
        Series::destroy($serie);
        return response()->noContent();
    }
}
