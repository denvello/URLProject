<?php

namespace App\Models;

use App\Models\Scans;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Scans extends Model
{
    use HasFactory;
    protected $fillable = [
        'qr_code_id',
        'user_id',
        'scanned_at',
        'ip_address',
        'scans_location',
    ];
}
