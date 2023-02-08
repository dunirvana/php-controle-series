<?php

namespace App\Http\Controllers;
use App\Models\Episode;
use App\Models\Season;
use App\Repositories\EpisodesRepository;
use Symfony\Component\HttpFoundation\Request;

class EpisodesController
{
    public function __construct(private EpisodesRepository $repository)
    {
    }

    public function index(Season $season)
    {
        return view('episodes.index', [
            'episodes' => $season->episodes,
            'mensagemSucesso' => session('mensagem.sucesso')
        ]);
    }

    public function update(Request $request, Season $season)
    {
        $serie = $this->repository->update($request, $season);

        return to_route('episodes.index', $season->id)->with('mensagem.sucesso', 'Episódios marcados como assistidos');
    }
}
