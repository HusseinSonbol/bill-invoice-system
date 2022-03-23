<?php

namespace App\Models;

use App\Models\safe;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class bill extends Model
{
    use HasFactory;
    public $incrementing = false;


    protected $fillable = [
        'user_id',
        'safe_id',
        'total_price'
    ];

    public function user(){
    return $this->belongsTo(User::class);
    }

    public function safe(){
    return $this->belongsTo(safe::class);
    }
    public function items()
    {
        return $this->hasMany(item_bill::class);
    }

}



