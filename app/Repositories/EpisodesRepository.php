<?php

namespace App\Repositories;

use Symfony\Component\HttpFoundation\Request;
use App\Models\Season;

interface EpisodesRepository
{
    public function update(Request $request, Season $season);
}
