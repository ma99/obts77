<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Helper extends Model
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

    public function reviews()
    {
         return $this->morphMany(Review::class, 'owner');
    }

    public function add($data)
    {
        return $this->create($data);
    }

    public function saveImagesOf($images, $helper)
    {
        foreach ($images as $image) {            
            $helper->images()->create(jsObjectToPhpArray($image));
        }
        return;
    } 

    public function findBy($id)
    {
        return $this->findOrFail($id);
    }
}
