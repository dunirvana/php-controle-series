<?php

namespace App\Listeners;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use App\Events\SeriesDeleted as SeriesDeletedEvent;

class DeleteSeriesCover implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    { }

    public function handle(SeriesDeletedEvent $event)
    {
        Storage::disk('public')->delete($event->seriesCoverPath);
    }
}
