<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tool extends Model
{
    protected $guarded = [];

    public function borrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class);
    }
}