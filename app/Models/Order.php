<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'order_id';

    protected $fillable = [
        'total_price',
        'status',
        'user_id',
    ];

    protected $casts = [
        'total_price' => 'decimal:8,2',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
