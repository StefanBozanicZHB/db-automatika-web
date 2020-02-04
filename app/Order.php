<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['date', 'client_id', 'account_number', 'total', 'paid', 'type'];
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function orders_items()
    {
        return $this->hasMany(Order_item::class);
    }
}
