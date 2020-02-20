<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'dba_clients';

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
