<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Author;

class Book extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $guarded = ['id'];

    public function authors()
    {
        return $this->hasOne(Author::class, 'id', 'author_id') ;
    }
    
}
