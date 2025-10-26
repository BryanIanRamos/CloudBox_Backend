<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $primaryKey = 'branch_id';

    public $fillable = [
        'name',
        'address',
        'img_path',
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    
}
