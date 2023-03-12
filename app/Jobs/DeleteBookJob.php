<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Book;

class DeleteBookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public $book;

    public function __construct($book)
    {
        $this->book = $book; 
    }

    /**
     * Execute the job.
     */

    public function handle(): void
    {
        $delete_book = Book::find($this->book);
        $delete_book->delete();
        Log::info($delete_book);
    }
}
