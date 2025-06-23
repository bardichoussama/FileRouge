<?php

namespace Modules\PkgApprenant\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\PkgApprenant\Models\Groupe;
use Carbon\Carbon;

class Promotion extends Model
{
    protected $fillable = ['name', 'description', 'start_date', 'end_date', 'is_active'];
    
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];
    
    /**
     * Scope to get promotion by starting year
     */
    public function scopeByYear($query, $year)
    {
        return $query->whereYear('start_date', $year);
    }
    
    /**
     * Scope to get currently active promotion based on date range
     */
    public function scopeActive($query, $date = null)
    {
        $date = $date ?: Carbon::now()->toDateString();
        return $query->where('start_date', '<=', $date)
                    ->where('end_date', '>=', $date);
    }
    
    /**
     * Get current active promotion
     * This works for promotions that span years like 2024-2025
     */
    public static function current()
    {
        return static::active()->first();
    }
    

    public static function activeOn($date = null)
    {
        return static::active($date)->first();
    }

    // Computed attribute: year portion of start_date
    public function getStartYearAttribute()
    {
        return $this->start_date?->year;
    }
    
    public function groupes()
    {
        return $this->hasMany(Groupe::class, 'promotion_id');
    }
}