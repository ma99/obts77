<?php

namespace App\Http\Controllers\Admin;

use App\Bus;
use App\Services\Staff\Service;
use Illuminate\Http\Request;

class StaffController extends Controller
{
	private $staff;

	public function __construct(Service $staff)
	{
		$this->staff = $staff;
	}

	public function store(Bus $bus)
    {
   		$attributes = $this->validateRequest();
   		
   		// $this->staff->addDriverToBus($driver, $bus); 	
   		// $this->staff->addHelperToBus($helper, $bus); 	
   		// $this->staff->addSupervisorToBus($supervisor, $bus); 	
   		return $this->staff->addStaffToBus($attributes, $bus); 	
    }

    public function destroy($type, $staff, Bus $bus)
     {
     	return $this->staff->removeStaffFromBus($staff, $type, $bus);
     } 

    protected function validateRequest()
    {
        return request()->validate([
            'driver' => 'nullable|numeric',
            'helper' => 'nullable|numeric',
            'supervisor' => 'nullable|numeric'
        ]);
    }   
}