<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramUse extends Model
{
    use HasFactory;


    protected $fillable = [
        'program_id',
        'amount',
        'tanggal',
        'note',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
        'amount'  => 'float',
    ];

    /**
     * Relasi ke program induk.
     */
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }
}