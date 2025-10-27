<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','category_id','name','limit_amount',
        'start_date','end_date','alert_threshold','notes'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function spent()
    {
        $start = $this->start_date ?? now()->startOfMonth();
        $end   = $this->end_date ?? now()->endOfMonth();

        return Transaction::where('user_id', $this->user_id)
            ->where('category_id', $this->category_id)
            ->where('type', 'expense')
            ->whereBetween('transacted_at', [$start->startOfDay(), $end->endOfDay()])
            ->sum('amount') ?: 0;
    }

    public function remaining()
    {
        return max(0, $this->limit_amount - $this->spent());
    }

    public function progress()
    {
        if ($this->limit_amount <= 0) return 0;
        return round(min(100, ($this->spent() / $this->limit_amount) * 100), 2);
    }

    public function status()
    {
        $p = $this->progress();
        if ($p >= 100) return 'over';
        if ($p >= $this->alert_threshold) return 'warning';
        return 'safe';
    }
}
