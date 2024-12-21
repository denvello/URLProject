<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Model;

class NewsUrlSimple extends Model
{
    protected $table = 'news_url'; // Nama tabel
    protected $fillable = ['url', 'title', 'desc', 'image_url', 'news_user_id']; // Kolom yang bisa diisi

}
