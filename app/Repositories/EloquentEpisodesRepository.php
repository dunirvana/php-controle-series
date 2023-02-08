<?php

namespace App\Repositories;

use App\Http\Requests\SeriesFormRequest;
use App\Models\Episode;
use App\Models\Season;
use App\Models\Series;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Request;

class EloquentEpisodesRepository implements EpisodesRepository
{
    public function update(Request $request, Season $season)
    {
        return DB::transaction(function () use ($request, $season) {

            $watchedEpisodes = $request->episodes;
            $season->episodes->each(function (Episode $episode) use ($watchedEpisodes) {
                $episode->watched = in_array($episode->id, $watchedEpisodes);
            });

            $season->push();
        });
    }
}
