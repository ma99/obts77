<?php

namespace App\Http\Controllers\Api;

//use GuzzleHttp\Client;
use App\Bus;
use App\Exceptions\DataNotFoundException;
use App\Http\Controllers\Controller;
use App\Libraries\DataException;
use App\Services\Staff\Service;
use Illuminate\Http\Request;

class SearchStaffController extends Controller
{
    /*private $driver;

    public function __construct(Driver $driver)
    {
        $this->driver = $driver;
    }*/

    private $staff;

    public function __construct(Service $staff)
    {
        $this->staff = $staff;
    }
    
   public function index(Bus $bus)
   {        
        // $drivers = $bus->drivers;
        $drivers = count($bus->drivers) ? $this->staff->detailsOf($bus->drivers) : [];

        $helpers = count($bus->helpers) ? $this->staff->detailsOf($bus->helpers) : [];
        $supervisors = count($bus->supervisors) ? $this->staff->detailsOf($bus->supervisors) : [];

         /*if (!count($drivers)) {
          // throw new DataNotFoundException('driver');
          DataException::dataNotFoundFor('driver');
        }*/
        
        return $staff[] = [
            'drivers' => $drivers,
            'helpers' => $helpers, 
            'supervisors' => $supervisors,                 
        ];        
   } 

   // public function stopList()
   // {
   //      $error = ['error' => 'Stop Not Found']; 
        
   //      $stops = Stop::all();
   //      return $stops->count() ? $stops : $error;
   // }
}
