<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = [];
    
    public function users()
    {
        return $this->belongsToMany(User::class); 
    }

    public function roleBy($name) {
        return $this->where('name', $name)->first();
    }
}
