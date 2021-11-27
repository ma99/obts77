<?php

namespace App\Services\Staff;

use App\Bus;

use App\Supervisor;
use App\Driver;
use App\Helper;

class Service 
{
	// private $supervisor;
	// private $driver;
	// private $helper;
	// private $bus;

	// public function __construct(Driver $driver, Helper $helper, Supervisor $supervisor, Bus $bus)
	// {
	// 	// $this->driver = $driver;
	// 	// $this->helper = $helper;
	// 	// $this->supervisor = $supervisor;
	// 	// $this->bus = $bus;
	// }	

	public function addStaffToBus($attributes, Bus $bus)
    {   		
   		
    	$driver = null;
    	$helper = null;
    	$supervisor = null;
    	
   		if ($driver = isset($attributes['driver'])) {   	
	   		$this->addDriverToBus($driver, $bus);
	   		$driver =  $this->infoFor(Driver::findOrFail($driver));
   		}

   		if ($helper = isset($attributes['helper'])) { 
	   		$this->addHelperToBus($helper, $bus); 	
	   		$helper =  $this->infoFor(Helper::findOrFail($helper));
   		}   			

   		if ($supervisor = isset($attributes['supervisor'])) {
	   		$this->addSupervisorToBus($supervisor, $bus); 	
	   		$supervisor =  $this->infoFor(Supervisor::findOrFail($supervisor));
   		}

   		return [
			'driver' => $driver,
			'helper' => $helper,
			'supervisor' => $supervisor
		];
    } 	

	public function addDriverToBus($driverId, Bus $bus)
	{
		$bus->addDriver($driverId);
	}

	public function addHelperToBus($helperId, Bus $bus)
	{
		$bus->addHelper($helperId);
	}
	
	public function addSupervisorToBus($supervisorId, Bus $bus)
	{
		$bus->addSupervisor($supervisorId);
	}

	public function removeStaffFromBus($id, $type, Bus $bus)
	{
		switch ($type) {
		    case "driver":
		        $bus->removeDriver($id);
		        break;
		    case "helper":
		        $bus->removeHelper($id);
		        break;
		    case "supervisor":
		        $bus->removeSupervisor($id);
		        break;
		}

		return [
			'id' => $id,
			'type' => $type
		];
	}

	public function detailsOf($persons)
    {
        foreach ($persons as $person) {   
            $personsInfo[] = $this->infoFor($person);
        }
        return $personsInfo;
    }

    public function infoFor($staff)
    {
    	$staffUserInfo = $staff->user;  

		return [
            'id' => $staff->id,
            'user_id' => $staff->user_id,
            'nid' => $staff->nid,
            'address' => $staff->address,
            'name' => $staffUserInfo->name, 
            'email' => $staffUserInfo->email, 
            'phone' => $staffUserInfo->phone, 
        ];
    }
}