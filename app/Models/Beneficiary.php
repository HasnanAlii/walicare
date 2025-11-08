<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficiary extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id', 'name', 'address', 'notes', 'photo_path',
        'delivered', 'delivered_at'
    ];

    protected $casts = [
        'delivered' => 'boolean',
        'delivered_at' => 'datetime'
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
