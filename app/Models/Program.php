<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

   protected $fillable = [
    'title','slug','category_id','summary','description',
    'target_amount','collected_amount','start_date','end_date',
    'location','status','is_featured','image','created_by','breakdown'
];


    protected $casts = [
        'breakdown' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_featured' => 'boolean'
    ];

    public function category()
    {
        return $this->belongsTo(ProgramCategory::class, 'category_id');
    }

     public function media()
    {
        return $this->hasMany(ProgramMedia::class, 'program_id'); 
    }

    public function milestones()
    {
        return $this->hasMany(Milestone::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function beneficiaries()
    {
        return $this->hasMany(Beneficiary::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function progressPercent(): float
    {
        if ($this->target_amount <= 0) return 0;
        return min(100, ($this->collected_amount / $this->target_amount) * 100);
    }
}
