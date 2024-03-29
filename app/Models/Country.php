<?php

namespace App\Models;

use App\Models\Orders\Range;
use App\Models\Users\Address;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $guarded = ['id'];

    public $timestamps = false;

    /**
     * ? RELATIONS
     */

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function ranges()
    {
        return $this->belongsToMany(Range::class, 'shippings')->withPivot('id', 'price');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
