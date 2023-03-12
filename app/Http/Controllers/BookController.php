<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use App\Events\BookUpdated;
use App\Jobs\DeleteBookJob;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Cache::has('books'))
        {
            return  response()->json(Cache::get('books'));
        }

        $book =  Book::with('authors')->get();
        Cache::put('books' , $book , now()->addMinutes(90) );

        return response()->json($book , 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,   $id)
    {
        Validator::make(request()->all(), [
            'name' => 'required|string',
            'publisher' => 'required|string'
        ])->validate();

        $book= Book::firstWhere('id', $id);

        if ($book != NULL) {          //The existence of the data to be updated is checked
                $book->name = $request->name;
                $book->publisher = $request->publisher;
                $book->save();
                if ($book->save()){
                    event(new BookUpdated($book->id));  //Event Running
                    $message = [
                        'data' => $book,
                        'status' => 'Updated',
                        'code' => 200
                    ];
                }else{
                    $message = [
                        'status' => 'Failed to update book!',
                        'code' => 422,
                    ];
                }
        } else {
            $message = [
                'status' => 'No Data Record!',
                'code' => 422,
            ];
        }
        return response()->json($message);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id) 
    {
        $delete_book = Book::find($id);

        if ($delete_book != NULL)
        {
            DeleteBookJob::dispatch($id);
            $message = [
                'data' => $delete_book,
                'status' => 'Insert to Queue',
                'code' => 200
            ];
        }
        else{
            $message = [
                'status' => 'No Data Record!',
                'code' => 422,
            ];
        }
        return response()->json($message);
    }
}
