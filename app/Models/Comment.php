<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    

    protected $fillable = ['feedback_id', 'user_id', 'comment'];

    public function feedback()
    {
        return $this->belongsTo(Feedback::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
