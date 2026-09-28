<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Asset extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'code',
        'total_quantity',
        'good',
        'damage',
        'borrowed',
        'lost',
        'is_available',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
