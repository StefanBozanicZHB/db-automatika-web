<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['total', 'client_id'];
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function orders_items()
    {
        return $this->hasMany(Order_item::class);
    }
}
