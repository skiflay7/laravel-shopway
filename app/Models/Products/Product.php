<?php

namespace App\Models\Products;

use App\Models\Wish;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{

    protected $guarded = ['id'];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * ? MISC
     */

    public function imagePath(string $filename): string
    {
        return asset('/storage/products') . '/' . $filename;
    }

    public function hasCategory(Category $category): bool
    {
        return $this->categories->contains($category);
    }

    /**
     * ? ATTRIBUTES
     */

     /**
      * Return name with uppercase on first character
      *
      * @param string $name
      * @return string
      */
    public function getNameAttribute(string $name): string
    {
        return ucfirst($name);
    }

    public function getMainImagePathAttribute()
    {
        return $this->images->isNotEmpty() 
            ? $this->imagePath($this->main_image->filename) 
            : "https://picsum.photos/800";
    }

    public function getMainImageAttribute()
    {
        if ($this->images->contains('is_main', true)) {
            return $this->images->skipUntil(function ($image){
                return $image->is_main;
            })->first();
        }

        return $this->images->first();
    }

    public function getIsInWishlistAttribute(): bool
    {
        if (!auth()->check()) {
            return false;
        }

        return $this->wishes->contains('user_id', auth()->id());
    }

    /**
     * Return truncate description of a product
     *
     * @return string
     */
    public function getExcerptAttribute(): string
    {
        return substr($this->description, 0, 200) . '...';
    }

    public function getCategoriesListAttribute()
    {
        return $this->categories->pluck('name')->implode(', ');
    }

    public function getPathAttribute()
    {
        return route('products.show', $this->slug);
    }

    public function getQuantityAttribute()
    {
        return $this->product_options->sum(function ($option){
            return $option->total_quantity;
        });
    }

    public function getPriceAttribute()
    {
        return $this->first_option ? $this->first_option->price : 0;
    }

    public function getFirstOptionAttribute()
    {
        return $this->product_options->first();
    }

    public function getSizesAttribute()
    {
        $sizesCollection = collect();
        $this->product_options->each(function ($productOption) use ($sizesCollection){
            return $productOption->sizes->each(function ($size) use (&$test){
                if (!$test->contains('id', $size->id)) {
                    $test->push($size);
                }
            });
        });
        
        return $sizesCollection;
    }

    /**
     * ? SCOPES
     */

    public function scopeActive(Builder $query)
    {
        return $query->where('active', true);
    }

     /**
      * Return a random collection of products
      *
      * @param Builder $query
      * @param string $with
      * @param integer $number
      * @return Builder
      */
    public function scopeRandomProducts(Builder $query, int $number = 12): Builder
    {
        return $query
            ->inRandomOrder()
            ->take($number);
    }

    public function scopeLast(Builder $query): self
    {
        return $query->latest()->first();
    }

    //

    public function hasSize(int $sizeId): bool
    {
        return $this->sizes->contains('id', $sizeId);
    }

    public function hasColor(int $colorId): bool
    {
        return $this->product_options()->where(function ($productOption) use($colorId){
            $productOption->where('color_id', $colorId);
        })->exists();
    }

    public function hasMaterial(int $materialId): bool
    {
        return $this->product_options()->where(function ($productOption) use($materialId){
            $productOption->where('material_id', $materialId);
        })->exists();
    }

    public function hasOptions(int $colorId, int $materialId): bool
    {
        return ($this->hasColor($colorId) && $this->hasMaterial($materialId));
    }

    public function refreshStatus(): void
    {
        if ($this->quantity > 1 && !$this->active) {
            $this->update([
                'active' => true,
            ]);
        }

        if ($this->quantity < 1 && $this->active) {
            $this->update([
                'active' => false,
            ]);
        }
    }

    /**
     * ? RELATIONS
     */

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function images()
    {
        return $this->hasManyThrough(Image::class, ProductOption::class);
    }

    public function wishes()
    {
        return $this->hasMany(Wish::class);
    }

    public function product_options()
    {
        return $this->hasMany(ProductOption::class);
    }
}
