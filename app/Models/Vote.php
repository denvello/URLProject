<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Feedback;

class Vote extends Model
{
    protected $fillable = ['feedback_id', 'user_id', 'type', 'created_at'];

    public function feedback()
    {
        return $this->belongsTo(Feedback::class);
    }
}

