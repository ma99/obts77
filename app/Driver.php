<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
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

    public function saveImagesOf($images, $driver)
    {
        foreach ($images as $image) {            
            $driver->images()->create(jsObjectToPhpArray($image));
        }
        return;
    } 

    // public function jsObjectToPhpArray($image)
    // {
    //     return json_decode(json_encode($image), true);
    // }

    public function findBy($id)
    {
        return $this->findOrFail($id);
    }    
}
