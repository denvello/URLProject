<?php

namespace App\Models;

use App\Models\Vote;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;



class Feedback extends Model
{
    protected $table = "feedbacks";

    // Daftar kolom yang bisa di-mass assign
    protected $fillable = [
        
        'title',
        'description',
        'category',
        'user_id',
        'created_at',
        'statusfeedback'
    ];
    
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function getUpvotesAttribute()
    {
        return $this->votes()->where('type', 'up')->count();
    }

    public function getDownvotesAttribute()
    {
        return $this->votes()->where('type', 'down')->count();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    // Relasi ke tabel User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('statusfeedback', 1);
    }
}
