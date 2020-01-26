<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
	protected $fillable = ['name'];

    public function order_items()
    {
        return $this->hasMany(Order_item::class);
    }
}
