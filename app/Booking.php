<?php

namespace App;

use App\Events\SeatStatusUpdated;
use App\Seat;
use App\Trip;
use App\booking;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $guarded = [];
    protected $trip;
    protected $seat;

    public function __construct(array $attributes = [])
    {
         parent::__construct($attributes);

         $this->createAndAssignInstences();        
    }

    public function createAndAssignInstences()
    {
        $this->trip = new Trip();
        $this->seat = new Seat();
    }
    
    public function setDateAttribute($value)
    {
    	return $this->attributes['date'] = date("Y-m-d", strtotime($value));
    }

    public function getDateAttribute($value)
    {
    	return date("d-m-Y", strtotime($value));
    }

    public function seats()
    {
    	return $this->hasMany(Seat::class);
    }

    public function seatsBy($booking)
    {
        $seats = $booking->seats()->get();
        return $seats->isNotEmpty() ? $seats :  null;
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    // public function schedule()
    // {
    //     return $this->belongsTo(Schedule::class);
    // }
    public function getBookingsByBusScheduleIdOnDate($id, $date)
    {
        return $this->where('bus_schedule_id', $id)
            ->where('date', $date)
            ->get();
    }  

    public function seatBooking(User $user, array $attributes)
    {
        $booking = $this->createBooking($user, $attributes);     

        $this->trip->createIfNotExistBy($booking->bus_schedule_id, $booking->city_route_id, $booking->date);

        $attributes['booking_ref'] = $booking->id;
        return $attributes= $this->seat->createSeatsFor($booking, $attributes);
        //return $this->bookedSeatInfo($attributes);        
    }

    public function createBooking(User $user, array $attributes)
    {
        unset($attributes['selected_seats']);     
        return $user->bookings()->create($attributes);
    }

    public function cancel($booking)
    {
       $busScheduleId = $booking->bus_schedule_id;
       // $busId = $booking->bus_id;               
       $travelDate = $booking->date;       
       $this->removeSeatBookedOrBuyingStatus($booking, $busScheduleId, $travelDate);
    }

    /*public function removeSeatBookedOrBuyingStatus($booking, $busScheduleId, $busId, $travelDate)
    {     
     
        $seats = $booking->load('seats');

        $booking->delete();

        foreach ($seats as $seat) {
            $updateSeatInfo = [
                    'seat_no' => $seat['seat_no'],
                    'status' => 'available',
            ];            
            $updateSeatInfo = json_decode(json_encode($updateSeatInfo)); //array to object
            broadcast(new SeatStatusUpdated($updateSeatInfo, $busScheduleId, $travelDate))->toOthers();
        }
        return;
    }*/

    public function removeSeatBy(Booking $booking, Seat $seat) {
        $totalSeats = $booking->total_seats;
        $seat->delete();
        $this->updateBooking($booking, $totalSeats);
        $this->broadcastSeatRemoved($booking, $seat);
    }

    public function updateBooking(Booking $booking, $totalSeats)
    {
        if ($totalSeats == 1) {
            $booking->delete();
            return;           
        }
        $ticketPrice = $this->ticketPrice($booking->amount, $totalSeats);

        $booking->amount = $this->deduct($ticketPrice, $booking->amount);

        $booking->total_seats = $this->deduct(1, $totalSeats);

        $booking->save();

        return;
    }

    public function deduct($value1, $value2)
    {
        return ($value2 - $value1);
    }

    public function ticketPrice($totalAmount, $totalSeats)
    {
        return ($totalAmount/$totalSeats);
    }

    public function broadcastSeatRemoved(Booking $booking, Seat $seat)
    {
        $updateSeatInfo = [
                'seat_no' => $seat->seat_no,
                'status' => 'available',
        ];            
        $updateSeatInfo = json_decode(json_encode($updateSeatInfo)); //array to object
        broadcast(new SeatStatusUpdated($updateSeatInfo, $booking->bus_schedule_id, $booking->date))->toOthers();
    }

    public function getBookingBy($id)
    {
        return $this->findOrFail($id);
    }

    public function customerInfo()
    {
        return $this->creator;
    }

    public function setSession()
    {
        session([
            'booking_id' => $this->id,
            'bus_id' => $this->bus_id,
            'schedule_id' => $this->schedule_id,
            'travel_date' => date("d-m-Y", strtotime($this->date)),
            'amount' => $this->amount
        ]);
    }

    public function getSession()
    {        
        return [
            'booking_id' => session('booking_id'),
            'bus_id' => session('bus_id'),
            'schedule_id' => session('schedule_id'),
            'travel_date' => session('travel_date'),           
            'amount' => session('amount')
        ];
    }

    public function info()
    {        
        return [
            'booking_id' => $this->id,
            //'bus_id' => $this->bus_id,
            'bus_schedule_id' => $this->bus_schedule_id,
            'travel_date' => date("d-m-Y", strtotime($this->date)),
            'amount' => $this->amount
        ];
    }
}