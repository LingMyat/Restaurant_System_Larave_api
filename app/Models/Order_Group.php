<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_Group extends Model
{
    use HasFactory;
    protected $fillable = [
        'table_id','total','order_id','status','served'
    ];
}
