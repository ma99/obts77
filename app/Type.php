<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $guarded = [];

    public function bus()
    {
    	return $this->hasOne(Bus::class);
    }
}
