<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'summary',
        'description',
        'target_amount',
        'collected_amount',
        'start_date',
        'end_date',
        'location',
        'status',
        'is_featured',
        'image',
        'created_by',
        'breakdown'
    ];

    protected $casts = [
        'breakdown' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_featured' => 'boolean',
    ];

    protected $attributes = [
    'target_amount' => null,
    ];

    /**
     * Route model binding menggunakan slug.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Relasi ke kategori program.
     */
    public function category()
    {
        return $this->belongsTo(ProgramCategory::class, 'category_id');
    }

    /**
     * Relasi ke media program (foto, video, teks).
     */
    public function media()
    {
        return $this->hasMany(ProgramMedia::class, 'program_id');
    }

    /**
     * Relasi ke donasi.
     */
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    
    /**
     * Relasi ke pengguna dana (program_uses).
     */
    public function uses()
    {
        return $this->hasMany(ProgramUse::class, 'program_id');
    }

    /**
     * Relasi ke pembuat program.
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Persentase progress donasi.
     */
    public function progressPercent(): float
    {
        if (empty($this->target_amount) || $this->target_amount <= 0) {
            return 0;
        }
        return round(min(100, ($this->collected_amount / $this->target_amount) * 100), 2);
    }

    /**
     * Total penggunaan dana.
     */
    public function totalUsed(): float
    {
        return (float) $this->uses()->sum('amount');
    }

    /**
     * Sisa saldo dana.
     */
    public function remainingFunds(): float
    {
        $collected = (float) ($this->collected_amount ?? 0);
        $used = $this->totalUsed();
        return max(0, $collected - $used);
    }
}
