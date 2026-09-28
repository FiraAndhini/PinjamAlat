<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetReturn extends Model
{
    protected static function booted(): void
    {
        static::creating(function ($assetReturn) {
            if (auth()->check()) {
                $assetReturn->user_id = auth()->id();
            }

            $assetReturn->return_at = now();

            if ($assetReturn->ticket) {
                $assetReturn->ticket->update([
                    'status' => 'returned',
                    'return_add' => now(),
                ]);
            }
        });
    }
}
