<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Events\SeatStatusUpdated;

class Seat extends Model
{
    protected $guarded = [];

    protected $casts = [
        'special' => 'boolean',
    ];
    
    public function booking()
    {
    	return $this->belongsTo(Booking::class);
    }

    public function getSeatBy($id)
    {
        return $this->findOrFail($id);
    }

    public function createSeatsFor($booking, $attributes)
    {
        extract($attributes);

        $seatNo = '';        

        foreach ($selected_seats as $seat ) {

            $seatNo = $seatNo .' '. $seat['seat_no'];            
            //$booking->seats()->create($seat);
            $booking->seats()->create([
                'seat_no' => $seat['seat_no'],
                'status'  => $seat['status'],
                'special' => $seat['special'],
            ]);
            
            //broadcast(new SeatStatusUpdatedEvent($seat, $scheduleId, $travelDate))->toOthers();
            broadcast(new SeatStatusUpdated($seat, $bus_schedule_id, $date))->toOthers();
        }

        $seats = trim($seatNo);
        $attributes['seats'] = $seats;        
        unset($attributes['selected_seats']); 

        //return response()->json($attributes);
        return $attributes;
    }
    
    public function updateSeatStatus(array $bookingInfo)
    {	
    	extract($bookingInfo);
        $seats = Seat::where('booking_id', $booking_id)->get();            
            foreach ($seats as $seat) {
                $seat->update([
                        'status' => 'confirmed',
                    ]);
                broadcast(new SeatStatusUpdated($seat, $bus_schedule_id, $travel_date))->toOthers();
            }
        return;
    }
}