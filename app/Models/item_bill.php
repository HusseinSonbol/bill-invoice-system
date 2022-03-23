<?php

namespace App\Models;

use App\Models\bill;
use App\Models\item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class item_bill extends Model
{
    use HasFactory;
    public $table = "item_bills";
    protected $primaryKey = ['bill_id', 'item_id'];

    public $incrementing = false;

    protected $fillable = [
        'bill_id',
        'item_id',
        'sale_price',
        'item_quantity',
        'total_item_price'
    ];

    public function items()
    {
        return $this->belongsTo(item::class,'item_id');
    }
    public function bills()
    {
        return $this->belongsTo(bill::class,'bill_id');
    }


}
