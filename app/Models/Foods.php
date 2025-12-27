<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Foods extends Model
{
    use HasFactory;
    use Search;

    protected $fillable = [
        'name',
        'description',
        'image',
        'price',
        'price_afterdiscount',
        'percent',
        'is_promo',
        'is_available',
        'categories_id'
    ];

    protected $searchable = ['name', 'description'];

    /**
     * Relationship to category
     */
    public function categories()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relationship to transaction items
     */
    public function transactionItems()
    {
        return $this->hasMany(TransactionItems::class, 'foods_id');
    }

    /**
     * Get all foods with total sold count (cached 5 mins)
     */
    public function getAllFoods()
    {
        return cache()->remember('foods.all', now()->addMinutes(5), function () {
            return self::with('categories')
                ->withSum('transactionItems as total_sold', 'quantity')
                ->get()
                ->map(function ($food) {
                    $food->total_sold = $food->total_sold ?? 0;
                    return $food;
                });
        });
    }

    /**
     * Get food details by ID with total sold (cached 5 mins)
     */
    public function getFoodDetails($id)
    {
        return cache()->remember("foods.detail.{$id}", now()->addMinutes(5), function () use ($id) {
            return self::with('categories')
                ->withSum('transactionItems as total_sold', 'quantity')
                ->where('id', $id)
                ->get()
                ->map(function ($food) {
                    $food->total_sold = $food->total_sold ?? 0;
                    return $food;
                });
        });
    }

    /**
     * Get promo foods (cached 5 mins)  
     */
    public function getPromo()
    {
        return cache()->remember('foods.promo', now()->addMinutes(5), function () {
            return self::with('categories')
                ->withSum('transactionItems as total_sold', 'quantity')
                ->where('is_promo', true)
                ->get()
                ->map(function ($food) {
                    $food->total_sold = $food->total_sold ?? 0;
                    return $food;
                });
        });
    }

    /**
     * Get favorite/best-selling foods (cached 5 mins)
     */
    public function getFavoriteFood()
    {
        return cache()->remember('foods.favorites', now()->addMinutes(5), function () {
            return self::with('categories')
                ->withSum('transactionItems as total_sold', 'quantity')
                ->having('total_sold', '>', 0)
                ->orderByDesc('total_sold')
                ->get()
                ->map(function ($food) {
                    $food->total_sold = $food->total_sold ?? 0;
                    return $food;
                });
        });
    }
}
