<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'icon',
    ];

    /**
     * Get all categories with caching (10 minutes)
     */
    public static function cached()
    {
        return cache()->remember('categories.all', now()->addMinutes(10), function () {
            return self::all();
        });
    }

    /**
     * Relationship to foods
     */
    public function foods()
    {
        return $this->hasMany(Foods::class, 'categories_id');
    }
}
