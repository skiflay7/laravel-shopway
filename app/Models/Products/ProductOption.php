<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'price' => 'integer',
        'weight' => 'integer',
    ];

    public function imagePath(string $filename): string
    {
        return asset('/storage/products') . '/' . $filename;
    }

    /**
     * ? Attributes
     */

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

    public function getSizesAvailableFormattedAttribute()
    {
        return $this->sizes->pluck('name')->implode(', ');
    }

    public function getClassnameAttribute()
    {
        if ($this->color->name === 'black') {
            return "bg-black text-white border-blue-500";
        }elseif($this->color->name === 'white'){
            return "bg-white text-gray-700 border-blue-500";
        }else{
            return "bg-{$this->color->name}-500 text-white border-blue-500";
        }
    }

    public function getDefaultSizeAttribute()
    {
        return $this->sizes->where('pivot.quantity', '>', Size::QUANTITY_ALERT)->first();
    }

    public function getTotalQuantityAttribute()
    {
        return $this->sizes->map(function ($size){
            return $size->pivot->quantity;
        })->sum();
    }

    //

    public function hasSize(int $sizeId)
    {
        return $this->sizes->contains('id', $sizeId);
    }

    public function whereSizeIs(int $sizeId): Size
    {
        return $this->sizes->firstWhere('id', $sizeId);
    }

    public function sizeQuantity(int $sizeId)
    {
        return $this->whereSizeIs($sizeId)->pivot->quantity;
    }

    /**
     * ? Relations
    */

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class)
            ->using(ProductOptionSize::class)
            ->withPivot('quantity');
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
