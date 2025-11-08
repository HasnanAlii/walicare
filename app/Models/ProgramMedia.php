<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramMedia extends Model
{
    use HasFactory;

    protected $fillable = ['program_id', 'type', 'path', 'caption', 'order'];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
