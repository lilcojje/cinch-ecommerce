<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'order_number',
        'customer_name',
        'customer_email',
        'total_amount',
    ];


    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}

