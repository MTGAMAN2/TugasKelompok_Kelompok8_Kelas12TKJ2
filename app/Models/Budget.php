<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','category_id','limit_amount','start_date','end_date','name'
    ];

    public function category(){ return $this->belongsTo(Category::class); }
}
