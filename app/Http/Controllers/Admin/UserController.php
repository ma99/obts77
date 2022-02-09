<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Role;
use App\User;

class UserController extends Controller
{
    public function index(User $user, $phone)
    {
        $user = $user->userBy($phone);

        if ($user) {            
            return [
                'id' => $user->id,
                'phone' => $user->phone,
                'name'  => $user->name,
                'email' => $user->email, //$user->email ?? 'N/A',
                'error' => '',
                'role' => $user->getRole('name'), //$user->getRole() ?? 'N/A',
                'roleDescription' => $user->getRole('description'),
            ];
        }
        return [
            'phone' => $phone,        
        ];
    }
    
    public function action(User $user, Role $role, $action)
    {
        $attributes = $this->validateRequest();
        $user = $user->userBy($attributes['phone']);
        $role = $role->roleBy($attributes['role']);

        if ($action == 'assign') {            
            $user->assign($role);
            return [
                'message' => 'Assigned',        
            ];
        }

        $user->revoke($role);        
        return [
            'message' => 'Revoked',        
        ];
    }

    public function roles()
    {
       return Role::where('name', '!=', 'super_admin')->get();
       // ddd(Role::where('name', '!=', 'super_admin')->get());
    }

    public function assign(User $user, Role $role)
    {
        $attributes = $this->validateRequest();
        $user = $user->userBy($attributes['phone']);
        $role = $role->roleBy($attributes['role']);

        $user->assign($role);

        return [
            'message' => 'Successfuly Assigned',        
        ];
    }

    public function revoke(User $user, Role $role)
    {
        $attributes = $this->validateRequest();   
        $user = $user->userBy($attributes['phone']);
        $role = $role->roleBy($attributes['role']);

        $user->revoke($role);

        return [
            'message' => 'Successfuly  Revoked',        
        ];
    }

    protected function validateRequest()
    {
        return request()->validate([
            // 'action' => 'required',
            'role' => 'required',
            'phone' => 'required',            
        ]);
    }
    
}