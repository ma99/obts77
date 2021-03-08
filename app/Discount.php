<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $error;

    public function getDiscountInfoBy(String $code)
    {
        return $this->where('code', $code)->first();
    }

    public function checkValidityOf($discount, $totalTicketPrice)
    {
    	$discountAmount = $this->calculateDiscount($discount->rate, $totalTicketPrice);

    	$minSpending = $this->isValidMinimumSpending($discount->minimum_spening, $totalTicketPrice);

 		if (!is_null($discount->cap)) {
    		
	    	$capValidity = $this->isDiscountAmountWithinCap($discountAmount, $discount->cap);

	    	if ($capValidity == false ) {
	    		$discountAmount = $this->$setCapAsDiscount($discount->cap);
	    	}
    	}

    	$startingDate = $this->isValid('starting', $discount->starting);
    	
    	$endingDate = $this->isValid('ending', $discount->ending);

    	$validity = $minSpending && $startingDate && $endingDate;

    	$arr = [
    		'isValid' => $validity,
    		'discount_amount' => $discountAmount,
    		// 'error'	=> 'Invalid code.',
            'error' => $this->error,
    	];

    	return $arr;
    }

    public function calculateDiscount($rate, $totalTicketPrice)
    {
    	return $totalTicketPrice*($rate*0.01);
    }

    public function isValidMinimumSpending($minimum_spening, $totalTicketPrice)
    {
    	if ( is_null($minimum_spening) ) {
    		return true;
    	}

    	if ($totalTicketPrice >= $minimum_spening) {
    		return true;
    	}

        $this->error = $minimum_spening.'৳ minimum spending required';
    	return false;
    }

    public function isDiscountAmountWithinCap($discountAmount, $cap)
    {
    	return ($discountAmount <= $cap) ? true : false;  
    }

    public function setCapAsDiscount($cap)
    {
    	return $cap;
    }

    public function isValid(String $status, $date)
    {
    	if (is_null($date)) {
    		return false;
    	}

    	$today = date("Y-m-d");

    	if ($status == 'starting') {
    		$date = date("Y-m-d", strtotime($date));
            
            if ($today >= $date) {
                return true;
            } 

            $this->error = "Offer/ Promotion is not strated yet!";
            return false;
    	}

    	$date = date("Y-m-d", strtotime($date));

		// return ($today <= $date) ? true : false;
        if ($today <= $date) {
            return true;
        } 

        $this->error = 'Sorry! Offer/ Promotion is over.';
        return false;
    }
}
