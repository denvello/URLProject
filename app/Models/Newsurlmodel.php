<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Commentsmodel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Newsurlmodel extends Model
{
    //buat newschart
    use HasFactory;
    
    protected $table = "news_url";

    // Daftar kolom yang bisa di-mass assign
    protected $fillable = [
        'url',
        'url_slug',
        'title',
        'desc',
        'image_url',
        'news_user_id',
        'likes_count',
        'views_count',
        'created_at',
        'updated_at'
    ];
     
 
    public function comments_join()
    {
    	//return $this->hasMany('App\Commentsmodel');
        return $this->hasMany(Commentsmodel::class, 'url_id', 'id'); 
        // Gunakan model Comment dan sesuaikan kolom relasi
    }

     // Relasi ke tabel User
     public function user()
     {
         return $this->belongsTo(User::class, 'news_user_id', 'id');
     }

    // Boot method untuk slug otomatis
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($news) {
            if (empty($news->url_slug)) {
                $news->url_slug = Str::random(20);
            }
        });
    } 
    //untuk buat chart newschart by date
    protected $casts = [
        'created_at' => 'datetime',
    ];

}
