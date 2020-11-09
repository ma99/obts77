<?php

namespace App\Exceptions;

use Exception;

class DataNotFoundException extends Exception
{
    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
     	\Log::debug(strtoupper($this->getMessage()). ' ' .'Data Not Available!');
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        $errors = [
            $this->getMessage() => ['Data Not Available!'],            
        ];
        return response()->json(['errors' => $errors], 500);
    }
}
