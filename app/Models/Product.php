<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Product extends Model
{
    use HasFactory;

    // Kolom yang dapat diisi secara massal (mass assignable)
    protected $fillable = [
        'product_name',
        'product_description',
        'product_image1_url',
        'product_image2_url',
        'product_image3_url',
        'product_image4_url',
        'product_image5_url',
        'product_image_qr',
        'product_price',
        'url',
        'product_contact_number',
        'product_viewed',
        'product_liked',
        'product_generated_qr_count',
        'product_user_id'

    ];

    protected $casts = [
        'product_images' => 'array',
    ];

    /**
     * Relasi ke model User.
     * Produk dimiliki oleh satu pengguna (user).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'product_user_id','id');
    }

    // public function userbelong()
    // {
    //     return $this->belongsTo(User::class, 'user_id', 'id');
    // }

    
    public function getImages()
    {
        $images = [];

        if ($this->product_image1_url) {
            $images[] = $this->product_image1_url;
        }

        if ($this->product_image2_url) {
            $images[] = $this->product_image2_url;
        }

        if ($this->product_image3_url) {
            $images[] = $this->product_image3_url;
        }

        if ($this->product_image4_url) {
            $images[] = $this->product_image4_url;
        }

        if ($this->product_image5_url) {
            $images[] = $this->product_image5_url;
        }

        return $images;
    }
    protected static function boot()
    {
        parent::boot();

        // Generate slug hanya jika belum ada slug
        static::creating(function ($product) {
            if (empty($product->product_slug)) {
                $product->product_slug = Str::random(20); // 20 karakter acak
            }
        });
    }
}
