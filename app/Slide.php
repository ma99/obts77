<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    protected $guarded = [];
    
    protected $casts = [
        'active' => 'boolean',
    ];

    public function image()
     {
         return $this->morphOne(Image::class, 'owner');
     } 

    public function add($data)
    {
        return $this->create($data);
    }

    public function activeSlides()
    {
        return $this->where('active', true)->get();
    }
    public function saveImageOf($image, $slide)
    {
        // foreach ($images as $image) {            
        //     $side->images()->create(jsObjectToPhpArray($image));
        // }
        $slide->image()->create(jsObjectToPhpArray($image[0]));
        return;
    }     

    public function findBy($id)
    {
        return $this->findOrFail($id);
    }

    public function detailsOf($slides)
    {
        foreach ($slides as $slide) {   
            $slidesInfo[] = $this->infoFor($slide);
        }
        return $slidesInfo;
    }

    public function infoFor($slide)
    {
        return [
            'id' => $slide->id,
            'active' => $slide->active,
            'image' => $slide->image
        ];
    }
}
