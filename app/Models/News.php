<?php

namespace App\Models;

use App\Models\News;
use Illuminate\Database\Eloquent\Model;



class News extends Model
{
    protected $table = "news_url";

    protected $fillable = ['title', 'desc', 'created_at'];

    public function comments()
    {
        return $this->hasMany(Comment::class, 'url_id', 'id')->latest();
       
    }
}
