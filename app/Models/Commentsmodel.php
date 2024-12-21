<?php

namespace App\Models;

use App\Models\Newsurlmodel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commentsmodel extends Model
{
    use HasFactory;

    protected $table = "comments";

    protected $fillable = [
        'user_id',
        'url_id',
        'comment_text',
        'image_comment',
        'created_at',
    ];
    
 
    public function newsurl_join()
    {
    	//return $this->belongsto('App\Newsurlmodel');
        return $this->belongsTo(Newsurlmodel::class, 'url_id', 'id'); // Gunakan model NewsUrl
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function commentReplies()
    {
        return $this->hasMany(CommentReply::class, 'comment_id', 'id');

    }
    
    // //tambahan untuk news comment dan reply di dashboard
    // public function replies()
    // {
    //     return $this->hasMany(Commentsmodel::class, 'comment_id', 'id'); // Replies refer back to parent comments
    // }

    


}
