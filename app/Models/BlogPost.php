<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;
    protected $fillable = [
        'slug', 'title', 'excerpt', 'author', 'date',
        'read_time', 'category_id', 'image', 'featured','content'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
