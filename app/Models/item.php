<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'quantity',
        'sale_price',
        'total_price',
    ];

    public function bills()
    {
        return $this->hasMany(item_bill::class);
    }
}
