<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SeriesFormRequest;
use App\Models\Series;
use App\Repositories\SeriesRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Symfony\Component\HttpFoundation\Request;

class SeriesController extends Controller
{
    public function __construct(private SeriesRepository $seriesRepository)
    {

    }
    public function index(Request $request)
    {
        $query = Series::query();

        if ($request->has('nome')) {
            $query->where('nome', $request->nome);
        }

        return $query->paginate(5);
    }

    public function store(SeriesFormRequest $request, Authenticatable $user)
    {
        if (!$user->tokenCan('series:create')) {
            return response()->json('Unauthorized', 401);
        }

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

    public function update(int $series, SeriesFormRequest $request, Authenticatable $user)
    {
        if (!$user->tokenCan('series:update')) {
            return response()->json('Unauthorized', 401);
        }

        //$series->fill($request->all());
        //$series->save();

        Series::where('id', $series)->update($request->all());

        return response('', 200);
    }

    public function destroy(int $serie, Authenticatable $user)
    {
        if (!$user->tokenCan('series:delete')) {
            return response()->json('Unauthorized', 401);
        }

        Series::destroy($serie);
        return response()->noContent();
    }
}
