<?php

namespace App\Models;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Cart extends Model
{
    protected $guarded = ['id'];

    public function getContentAttribute(string $content)
    {
        return unserialize($content);
    }

    /**
     * ? SCOPES
     */

    public function scopeFindByUser(Builder $query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeMissingOrderItems(Builder $query)
    {
        return $query->whereNotNull('order_id');
    }

    /**
     * ? RELATIONS
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
