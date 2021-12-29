<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Staff\Service;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Driver;
use App\Image;
use App\Role;

class DriverController extends Controller
{
    protected $request;
    protected $driver;
    protected $staff;
    protected $image;
    protected $role;

    public function __construct(Request $request, Driver $driver, Service $staff, Image $image, Role $role)
    {
        $this->request = $request;
        $this->driver = $driver;
        $this->staff = $staff;
        $this->image = $image;
        $this->role = $role;
    }

    public function store()
    {
        $attributes = $this->validateRequest();

        $images = $attributes['images'];

        unset($attributes['images']);

        $driver = $this->driver->add($attributes);

        $this->staff->assignRoleFor($this->role->roleBy('driver')->id, $driver);

        $this->driver->saveImagesOf($images, $driver);
        
        return $this->staff->infoFor($driver);
    }

    public function destroy(Request $request)
    {        
        
        $driver = $this->driver->findBy($request->id);
        
        if ($driver) {
            $this->image->removeImagesFromDataBaseOwnedBy('App\Driver', $request->id);
            $driver->delete();
        }

        $this->image->removeImagesFromStorage($request->images);

        return [
            'id' => $request->id,
            'message' => 'Driver deleted successfully'
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
                Rule::unique('drivers')->where(function ($query) {
                    return $query
                        ->where('user_id', $this->request->user_id);
                }),
            ]
        ],
        [
            'nid.unique' => ':input belongs to driver already exists!'
        ]);
    }
}
