<?php

namespace App\Policies;

use App\Booking;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class BookingPolicy
{
    use HandlesAuthorization;

    
    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    public function manage(User $user, Booking $booking)
    {
        // ddd('here');
        // return $user->is($booking->creator);
        return $user->id === $booking->creator_id
                ? Response::allow()
                : Response::deny('You do not own this booking.');
    }

    // public function search(User $user)
    // {
    //     ddd(auth()->phone);
    //     // return $user->phone === auth()->phone;
    //     return $user->id === $booking->creator_id;
    // }

    /**
     * Determine whether the user can view any bookings.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the booking.
     *
     * @param  \App\User  $user
     * @param  \App\Booking  $booking
     * @return mixed
     */
    public function view(User $user, Booking $booking)
    {
        //
    }

    /**
     * Determine whether the user can create bookings.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        
    }

    /**
     * Determine whether the user can update the booking.
     *
     * @param  \App\User  $user
     * @param  \App\Booking  $booking
     * @return mixed
     */
    public function update(User $user, Booking $booking)
    {
        return $user->id === $booking->creator_id;
    }

    /**
     * Determine whether the user can delete the booking.
     *
     * @param  \App\User  $user
     * @param  \App\Booking  $booking
     * @return mixed
     */
    public function delete(User $user, Booking $booking)
    {
        //return $user->id === $booking->creator_id; //nw
        //return $user->id == $booking->creator_id; 
        return $user->is($booking->creator);    
    }

    /**
     * Determine whether the user can restore the booking.
     *
     * @param  \App\User  $user
     * @param  \App\Booking  $booking
     * @return mixed
     */
    public function restore(User $user, Booking $booking)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the booking.
     *
     * @param  \App\User  $user
     * @param  \App\Booking  $booking
     * @return mixed
     */
    public function forceDelete(User $user, Booking $booking)
    {
        //
    }
}
