<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Like extends Model
{
    use HasFactory;

    /**
     * Mass assignment protection.
     * $guarded = [] berarti semua field boleh diisi.
     */
    protected $guarded = [];

    /**
     * Relasi polimorfik: "likeable" bisa merujuk ke Event, Program, dll.
     */
    public function likeable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Relasi ke user yang melakukan 'like'.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}