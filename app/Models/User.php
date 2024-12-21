<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'password',
        'remember_token',
        'user_ip',
        'user_agent',
        'user_location',
        'role',
        'email_verified_at',
        'user_avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    //ga perlu dipakai, karena sudah didefinisikan di model news_url dan comments
    // protected $table = "users";

    // public function news_urls()
    // {
    //     return $this->hasMany(Newsurlmodel::class, 'user_id', 'id');
    // }
    public function products()
    {
        return $this->hasMany(Product::class, 'product_user_id');
    }

    public function searchLogs()
    {
        return $this->hasMany(SearchLog::class, 'user_id', 'id');
    }
    //tambahan untuk di user profile dashboard
    public function comments()
    {
        return $this->hasMany(Commentsmodel::class, 'user_id', 'id');
    }

    public function replyComments()
    {
        return $this->hasMany(CommentReply::class, 'user_id', 'id');
    }

    // public function products()
    // {
    //     return $this->hasMany(Product::class, 'product_user_id', 'id');
    // }


}

