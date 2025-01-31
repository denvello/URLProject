<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentReply extends Model
{
    protected $table = "comment_replies";

    public function comment()
    {
        return $this->belongsTo(Commentsmodel::class,'id','comment_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
