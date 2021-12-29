<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\DataNotFoundException;
use App\Http\Controllers\Controller;
use App\Libraries\DataException;
use App\Services\Staff\Service;
use Illuminate\Http\Request;
use App\Helper;


class SearchHelpersController extends Controller
{    
    private $staff;

    public function __construct(Service $staff)
    {
        $this->staff = $staff;
    }
    
   public function index()
   {   
        $helpers = Helper::all();

         if (!count($helpers)) {
          DataException::dataNotFoundFor('helper');
        }
        
        return $this->staff->detailsOf($helpers);
   }    
}
