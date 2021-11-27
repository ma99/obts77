<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    public function buses()
    {
        return $this->belongsToMany(Bus::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }    

    // public function detailsOf($drivers)
    // {
    //     foreach ($drivers as $driver) {   
    //         $driverUserInfo = $driver->user;  
   
    //         $driversInfo[] = [
    //             'id' => $driver->id,
    //             'user_id' => $driver->user_id,
    //             'nid' => $driver->nid,
    //             'address' => $driver->address,
    //             'name' => $driverUserInfo->name, 
    //             'email' => $driverUserInfo->email, 
    //             'phone' => $driverUserInfo->phone, 
    //         ];
    //     }

    //     return $driversInfo;
    // }
}
