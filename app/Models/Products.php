<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{

    use HasFactory; 


    protected $primaryKey = 'product_id';

    public $fillable = [
        'name',
        'description',
        'price',
        'user_id',
    ];

    public $casts = [
        'price' => 'decimal:2',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
