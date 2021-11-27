<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    public function buses()
    {
        return $this->belongsToMany(Bus::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
