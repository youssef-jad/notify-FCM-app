<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    public function scopeGroupedKeys($query)
    {
        return $query->groupBy('device_key');
    }

    public function allDevices()
    {
        // here we are going to return a non repeated list of devices
        return $this->all()->groupBy('device_key');
    }
}
