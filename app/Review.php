<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $guarded = [];

    const REVIEWED_NO = 0;
    const REVIEWED_YES = 1;

    public function owner()
    {
        return $this->morphTo();
    }

    public function store($attributes)
    {
        return $this->create($attributes);
    }
}
