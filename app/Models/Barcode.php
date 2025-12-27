<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barcode extends Model
{
    use HasFactory;

    protected $fillable = [
        'table_number',
        'token',
        'image',
        'is_active',
        'qr_value',
        'users_id',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
