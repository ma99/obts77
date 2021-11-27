<?php

namespace App\Http\Controllers\Api;

//use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\DataNotFoundException;
use App\Libraries\DataException;
use App\Bus;
use App\Stop;


class SearchBusesController extends Controller
{
   public function index()
   {        
        // $error = ['error' => 'No results found'];

        $buses = Bus::with('seat_plan')->get(); 
        
        if (!count($buses)) {
          // throw new DataNotFoundException('bus');
          DataException::dataNotFoundFor('bus');
        }

        foreach ($buses as $bus) {           
            $busList[] = [
                'bus'   => $bus,
                'total_seats' => $bus->seat_plan->total_seats
            ];
        }        
        
        return $busList;
   } 

   // public function stopList()
   // {
   //      $error = ['error' => 'Stop Not Found']; 
        
   //      $stops = Stop::all();
   //      return $stops->count() ? $stops : $error;
   // }
}
