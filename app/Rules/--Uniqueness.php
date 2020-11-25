<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Route;

class Uniqueness implements Rule
{
    protected $param;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($param)
    {
       $this->param = $param; 
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $param = $this->param;
        
        /** check if both cities are selected same **/
        if ($value === $param) {
            return false;
        }

        $result = Route::where(function ($query) use ($value, $param) {
        return $query->where('first_city', $value)
            ->orWhere('first_city', $param);
        })
        ->where(function ($query) use ($value, $param) {
        return $query->where('second_city', $value)
            ->orWhere('second_city', $param);
        })
        ->first();
    return $result ? false : true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $city = $this->param;
        return ":input to ${city} already exists or invalid.";
    }
}