<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\DataNotFoundException;
use App\Http\Controllers\Controller;
use App\Libraries\DataException;
use App\Services\Staff\Service;
use Illuminate\Http\Request;
use App\Supervisor;


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
          DataException::dataNotFoundFor('supervisor');
        }
        return $this->staff->detailsOf($supervisors);
   }    
}
