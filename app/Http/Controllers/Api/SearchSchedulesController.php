<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Libraries\DataException;

use App\Schedule;
use App\Bus;

class SearchSchedulesController extends Controller
{
    
     // public function index()
     // {        
     //    $error = ['error' => 'No results found'];

     //    $schedules = Schedule::all();
     //    return $schedules->count() ? $schedules : $error;        
        
     // }
    public function index()
     {
        return tap(Schedule::all(), function($schedules) {
            if (!count($schedules)) {     
                DataException::dataNotFoundFor('schedule');
            }
        });
     }

     public function busSchedules(Bus $bus)
     {
          // $error = ['error' => 'No results found'];
          $schedules = $bus->schedules()->get();
          
          if ( $schedules->count() ) {
               return $schedules;
          }
            throw new ModelNotFoundException('Schedules not available.');
        
     }
    // public function busSchedules(Bus $bus)
    // {
    //     return tap($bus->schedules()->get(), function($schedules) {
    //         if (!count($schedules)) {     
    //             DataException::dataNotFoundFor('schedule');
    //         }
    //     });
    // }
}
