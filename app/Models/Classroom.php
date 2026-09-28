<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'major_id',
        'name',
        'level',
        'is_active',
    ];

    public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class);
    }
    public function students()
    {
        return $this->hasMany(Student::class);
    }
}