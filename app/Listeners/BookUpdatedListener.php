<?php

namespace App\Listeners;

use App\Events\BookUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Jobs\DeleteBookJob;
use Illuminate\Support\Facades\DB;
use App\Models\Log;

class BookUpdatedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BookUpdated $event): void
    {   
        $log = new Log;
        $log->book_id = intval($event->book);
        $log->save();  //saved in log table
    }
}
