<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Staff\Service;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Supervisor;
use App\Image;
use App\Role;

class SupervisorController extends Controller
{
    protected $request;
    protected $supervisor;
    protected $staff;
    protected $image;
    protected $role;

    public function __construct(Request $request, Supervisor $supervisor, Service $staff, Image $image, Role $role)
    {
        $this->request = $request;
        $this->supervisor = $supervisor;
        $this->staff = $staff;
        $this->image = $image;
        $this->role = $role;
    }

    public function store()
    {
        $attributes = $this->validateRequest();

        $images = $attributes['images'];

        unset($attributes['images']);

        $supervisor = $this->supervisor->add($attributes);
        
        $this->staff->assignRoleFor($this->role->roleBy('supervisor')->id, $supervisor);

        $this->supervisor->saveImagesOf($images, $supervisor);
        
        return $this->staff->infoFor($supervisor);
    }

    public function destroy(Request $request)
    {                
        $supervisor = $this->supervisor->findBy($request->id);
        
        if ($supervisor->images) {
            $this->image->removeImagesFromDataBaseOwnedBy('App\Supervisor', $request->id);
            $this->image->removeImagesFromStorage($request->images);
        }
        $supervisor->delete();

        return [
            'id' => $request->id,
            'message' => 'Supervisor deleted successfully'
        ];
    }

    protected function validateRequest()
    {
        return request()->validate([
            'user_id' => 'required',
            'address' => 'required',            
            'images' => 'nullable|array',            
            'nid' => [
                'required',
                'numeric',
                'digits_between:5,17',
                Rule::unique('supervisors')->where(function ($query) {
                    return $query
                        ->where('user_id', $this->request->user_id);
                }),
            ]
        ],
        [
            'nid.unique' => ':input belongs to supervisor already exists!'
        ]);
    }
}
