<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Staff\Service;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Helper;
use App\Image;
use App\Role;

class HelperController extends Controller
{
    protected $request;
    protected $helper;
    protected $staff;
    protected $image;
    protected $role;

    public function __construct(Request $request, Helper $helper, Service $staff, Image $image, Role $role )
    {
        $this->request = $request;
        $this->helper = $helper;
        $this->staff = $staff;
        $this->image = $image;
        $this->role = $role;
    }

    public function store()
    {
        $attributes = $this->validateRequest();

        $images = $attributes['images'];

        unset($attributes['images']);

        $helper = $this->helper->add($attributes);

        $this->staff->assignRoleFor($this->role->roleBy('helper')->id, $helper);

        $this->helper->saveImagesOf($images, $helper);
        
        return $this->staff->infoFor($helper);
    }

    public function destroy(Request $request)
    {        
        
        $helper = $this->helper->findBy($request->id);
        
        if ($helper) {
            $this->image->removeImagesFromDataBaseOwnedBy('App\Helper', $request->id);
            $helper->delete();
        }

        $this->image->removeImagesFromStorage($request->images);

        return [
            'id' => $request->id,
            'message' => 'Helper deleted successfully'
        ];
    }

    protected function validateRequest()
    {
        return request()->validate([
            'user_id' => 'required',
            'address' => 'required',            
            'images' => 'nullable|array',            
            // 'nid' => 'required|numeric|digits_between:5,17',
            'nid' => [
                'required',
                'numeric',
                'digits_between:5,17',
                Rule::unique('helpers')->where(function ($query) {
                    return $query
                        ->where('user_id', $this->request->user_id);
                }),
            ]
        ],
        [
            'nid.unique' => ':input belongs to helper already exists!'
        ]);
    }
}
