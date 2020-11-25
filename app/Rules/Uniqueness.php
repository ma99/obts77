<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
// use App\Route;

class Uniqueness implements Rule
{
    protected $param;
    protected $params;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
       $this->params = $params; 
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
        $param = $this->params['param'];
        
        /** check if both cities are selected same **/
        if ($value === $param) {
            return false;
        }

        $modelName = $this->params['modelName'];
        $field1 = $this->params['field1'];
        $field2 = $this->params['field2'];

        $result = $modelName::where(function ($query) use ($field1, $value, $param) {
        return $query->where($field1, $value)
            ->orWhere($field1, $param);
        })
        ->where(function ($query) use ($field2, $value, $param) {
        return $query->where($field2, $value)
            ->orWhere($field2, $param);
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
        return ":input to {$this->params['param']} already exists or invalid.";
    }
}