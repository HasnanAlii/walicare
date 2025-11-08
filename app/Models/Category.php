<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi (mass assignment).
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    /**
     * Relasi: satu kategori memiliki banyak event.
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
