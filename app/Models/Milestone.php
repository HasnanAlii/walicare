<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id', 'title', 'description', 'amount', 'target_date', 'is_reached'
    ];

    protected $casts = [
        'target_date' => 'date',
        'is_reached' => 'boolean'
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
