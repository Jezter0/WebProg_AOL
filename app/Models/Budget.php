<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'category_id', 'amount', 'month', 'year'];

    protected $appends = ['spent', 'progress_percentage'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'category_id', 'category_id')
                    ->where('user_id', $this->user_id)
                    ->whereYear('date', $this->year)
                    ->whereMonth('date', $this->month);
    }

    public function getSpentAttribute()
    {
        if (!$this->exists) return 0;
    
        return Transaction::where('user_id', $this->user_id)
                        ->where('category_id', $this->category_id)
                        ->whereYear('date', $this->year)
                        ->whereMonth('date', $this->month)
                        ->sum('amount') ?? 0;
    }

    public function getProgressPercentageAttribute()
    {
        if ($this->amount == 0) return 0;
        return min(($this->spent / $this->amount) * 100, 100);
    }
}