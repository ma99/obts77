<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Ticket\Service;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    protected $ticket;

    public function __construct(Service $ticket)
    {
        $this->ticket = $ticket;
    }
    
    public function search()
    {
        $attributes = $this->validateRequest();
        return $this->ticket->find($attributes['searchBy'], $attributes['search']);
    }

    public function destroy()
    {
        // admin or use policy
        // $this->authorize('manage', $booking);
        $bookings = request()->validate([
            'bookings' => 'required',
        ]);
        return $this->ticket->delete($bookings);
    }
    
    protected function validateRequest()
    {
        return request()->validate([
            'searchBy' => 'required',
            'search'   => 'required'
        ]);
    }
}
