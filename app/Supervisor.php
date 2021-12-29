<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    protected $guarded = [];

    public function buses()
    {
        return $this->belongsToMany(Bus::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }    

    public function images()
     {
         return $this->morphMany(Image::class, 'owner');
     } 

    public function add($data)
    {
        return $this->create($data);
    }    

    public function saveImagesOf($images, $supervisor)
    {
        foreach ($images as $image) {            
            $supervisor->images()->create(jsObjectToPhpArray($image));
        }
        return;
    } 

    public function findBy($id)
    {
        return $this->findOrFail($id);
    }
}
