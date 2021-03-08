<?php

namespace App\Exceptions;

use Exception;

class DiscountRelatedException extends Exception
{
    
    protected $error;
    protected $code;
    protected $message;


    public function __construct($error, $message, $code, Exception $exception=NULL)

    {
        parent::__construct($message, $code, $exception);
        $this->error = $error;
        $this->code = $code;
        $this->message = $message;
    }
    public function report()
    {
     	// \Log::debug(strtoupper($this->getMessage()). ' ' .'Data Not Available!');
        \Log::debug(strtoupper($this->error). ' ' .$this->message);
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
            // $this->getMessage() => ['Data Not Available!'],            
            $this->error => [$this->getMessage()]
        ];
        return response()->json(['errors' => $errors], 500);
    }
}
