<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    protected $image;

    public function __construct(Image $image)
    {
        $this->image = $image;
    }
   
    public function upload(Request $request)
    {
        $attributes = $this->validateRequest();

        $file = $request->file('image');   
        $name = uniqid().'.'.$file->extension();

        if ($attributes['directory']) {

            $path = "{$attributes['directory']}/{$name}";
            // $request->file('image')->store("public/{$path}");
            $request->file('image')->storeAs(
                "public/{$attributes['directory']}", $name
            );
        } else {            
            $path = "images/{$name}";            
            // $request->file('image')->store("public/{$path}");
            $request->file('image')->storeAs(
                'public/images', $name
            );
        }

        return [
            'message' => 'Image uploaded successfully',
            'name' => $name,
            'path' => $path,
            'title' => $attributes['title']
        ];     
    }

    public function destroy(Request $request)
    {
        $this->image->removeImagesFromStorage($request->path);

        return [
            'message' => 'Image deleted successfully'
        ];
    }

    protected function validateRequest()
    {
        return request()->validate([
           'image' => 'required|image|dimensions:min_width=500,min_height=300',
           'title' => 'required|min:5|max:150',
           'directory' => 'nullable',
        ]);
    }        
}
