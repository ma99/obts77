<?php

namespace App\Http\Controllers\Api;

//use GuzzleHttp\Client;
use App\Exceptions\DataNotFoundException;
use App\Http\Controllers\Controller;
use App\Libraries\DataException;
use App\Services\Staff\Service;
use Illuminate\Http\Request;
use App\Driver;


class SearchDriversController extends Controller
{    
    private $staff;

    public function __construct(Service $staff)
    {
        $this->staff = $staff;
    }
    
   public function index()
   {   
        $drivers = Driver::all();

         if (!count($drivers)) {
          // throw new DataNotFoundException('driver');
          DataException::dataNotFoundFor('driver');
        }
        return $this->staff->detailsOf($drivers);
   }    
}
