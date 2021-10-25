<?php

namespace App\Services\Ticket;

use Illuminate\Support\Facades\Gate;
use App\Booking;
use App\User;
use App\Seat;

class Service 
{
	private $booking;
	private $user;
	private $seat;

	public function __construct(User $user, Seat $seat, Booking $booking)
	{
		$this->user = $user;
		$this->seat = $seat;
		$this->booking = $booking;
	}

	public function find($searchBy, $search)
	{
		if ($searchBy === 'phone') {
			return $this->findByPhone($search); 
		}
		return $this->findByBooking($search);
	}

	public function findByPhone($search)
	{
		return optional($this->user->userBy($search), function ($user) {
			if ( $this->requestUserIsAdminOr($user) ) {
				$bookings = $this->bookingInfosOf($user);		
			    return $this->info($bookings, $user);
			}
			return $this->info(['Sorry! The information you are looking does not belong to you.']);			
		});
	}

	public function findByBooking($search)
	{
		return optional($this->booking->getBookingBy($search), function($booking) {	
			if ( $this->requestUserIsAdminOr($booking->creator) ) { 
				$bookings = [1 => [
		    		'booking' => $booking,
		    		'seats' => $this->booking->seatsBy($booking)
		    	]];
			    return $this->info($bookings, $booking->creator);
			}
			return $this->info(['Sorry! You are not allowed.']);			

		});
	}

	public function requestUserIsAdminOr($searchedUser)
	{
		$user = auth()->user();
		return ($user->isAdmin() || $user->phone === $searchedUser->phone) ?? false;
	}

	public function bookingInfosOf($user)
	{
		$bookings = $this->user->allBookingsBy($user);
		// ddd($bookings);

		if ( $bookings->isEmpty() ) {
			return null;
		}
		
		foreach($bookings as $key => $booking) {			
		    $bookings[$key] = [
				'booking' => $booking,
	    		'seats' => $this->booking->seatsBy($booking)
			];
		}
		return $bookings;
	}

	public function info($bookings, $user=null)
	{
		return [
	    	'user' => $user,
	    	'bookings' => $bookings
	    ];
	}	

	public function delete($bookings)
	{
		$i = 0;
		foreach ($bookings as $booking) {
			$booking = $this->jsArrayOfObjectToPhpObject($booking);			
			$this->booking->removeSeatBy(
				$this->booking->getBookingBy($booking[$i]->bookingId), 
				$this->seat->getSeatBy($booking[$i]->seat->id)
			);
			$i++;
		}	
		return $this->info(['Deleted Successfully!']);
	}

	public function jsArrayOfObjectToPhpObject($data)
	{
		return json_decode(json_encode($data));
	}

	public function requestUserIsAdminOrAuthorized($searchedUser)
	{
		$user = auth()->user();
		return ($user->isAdmin() || $user->phone === $searchedUser->phone) ?? false;
	}
}