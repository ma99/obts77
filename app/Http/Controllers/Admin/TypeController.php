<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Type;

class TypeController extends Controller
{
    public function store()
    {     
        $attributes = $this->validateRequest();
        
        return Type::create($attributes);

    }

    public function destroy(Type $type)
    {
        $error = ['error' => 'No results found'];
        
        if($type) {
            $type->delete();
            return 'success';            
        }
        return $error;
    }

    protected function validateRequest()
    {
        return request()->validate([
            'name' => 'required|unique:types',
            'key'   => 'required'
        ]);
    }
}
