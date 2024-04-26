<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    // protected $table = 'products';
    protected $fillable = ['name', 'description', 'price', 'image', 'location', 'favorite'];
    use HasFactory;
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    // public function favouriteProduct()
    // {
    //     return $this->hasMany(UserProductFavourite::class);
    // }

    // protected isFav(): Attributte
    // {
    //     get: fn () => $this->users()->where('id', auth()->user()->id)
    // }

    // $product->is_fav

}
