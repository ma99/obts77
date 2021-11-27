<?php

namespace App\Http\Controllers\Api;

//use GuzzleHttp\Client;
use App\Exceptions\DataNotFoundException;
use App\Http\Controllers\Controller;
use App\Libraries\DataException;
use App\Services\Staff\Service;
use App\Supervisor;
use Illuminate\Http\Request;


class SearchSupervisorsController extends Controller
{
    private $staff;

    public function __construct(Service $staff)
    {
        $this->staff = $staff;
    }
    
   public function index()
   {   
        $supervisors = Supervisor::all();

         if (!count($supervisors)) {
          // throw new DataNotFoundException('supervisor');
          DataException::dataNotFoundFor('supervisor');
        }
        return $this->staff->detailsOf($supervisors);
   }    
}
