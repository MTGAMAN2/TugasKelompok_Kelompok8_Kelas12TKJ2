<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id','wallet_id','category_id','vendor_id',
        'type','amount','transacted_at','note','attachment_path'
    ];

    protected $casts = ['transacted_at' => 'date'];

    public function user(){ return $this->belongsTo(User::class); }
    public function wallet(){ return $this->belongsTo(Wallet::class); }
    public function category(){ return $this->belongsTo(Category::class); }
    public function vendor(){ return $this->belongsTo(Vendor::class); }
}
