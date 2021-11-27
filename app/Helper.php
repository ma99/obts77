<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Helper extends Model
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
