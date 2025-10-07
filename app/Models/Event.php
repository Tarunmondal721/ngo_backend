<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'date',
        'time',
        'location',
        'category_id',
        'description',
        'image',
        'attendees',
        'impact',
        'status',
        'price',
        'featured',
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
