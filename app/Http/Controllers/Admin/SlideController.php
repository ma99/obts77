<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Staff\Service;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Slide;
use App\Image;

class SlideController extends Controller
{
    protected $request;
    protected $slide;
    // protected $staff;
    protected $image;

    public function __construct(Request $request, Slide $slide, Image $image)
    {
        $this->request = $request;
        $this->slide = $slide;
        // $this->staff = $staff;
        $this->image = $image;
    }

    public function store()
    {
        $attributes = $this->validateRequest();

        $image = $attributes['image'];

        unset($attributes['image']);

        $slide = $this->slide->add($attributes);

        $this->slide->saveImageOf($image, $slide);
        
        return $this->slide->infoFor($slide);
    }

    public function destroy(Request $request, Slide $slide)
    {                
        $image = $slide->image;
        $id = $slide->id;
        
        if ($slide) {
            $this->image->removeImagesFromDataBaseOwnedBy('App\Slide', $id);
            $slide->delete();
        }

        $this->image->removeImagesFromStorage($image);

        return [
            'id' => $id,
            'message' => 'Slide deleted successfully.'
        ];
    }

    public function update(Slide $slide)
    {   
        $attributes = $this->validateRequest();

        unset($attributes['image']);

        $slide->update($attributes);

        return response()->json([
            'status' => 'success',
        ]);        
    }

    protected function validateRequest()
    {
        return request()->validate([
            'active' => 'required|boolean',            
            'image' => 'required|array|size:1'
        ]);
    }
}
