<?php

namespace App\Models;

use Attribute as GlobalAttribute;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'price', 'image', 'location', 'favorite', 'refresh'];
    use HasFactory;
    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
    public function product_users() : HasMany
    {
        return $this->hasMany(ProductUser::class);
    }

}
