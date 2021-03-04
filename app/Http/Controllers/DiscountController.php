<?php

namespace App\Http\Controllers;

// use App\Libraries\DataException;
use App\Libraries\DiscountException;
use Illuminate\Http\Request;
use App\Discount;

class DiscountController extends Controller
{
    protected $discount;

    public function __construct(Discount $discount)
    {
        // $this->middleware('auth');
        $this->discount = $discount;
    }
    
    public function index()
    {
        $attributes = $this->validateRequest();

        $code = $attributes['code'];
        $amount = $attributes['amount'];

        $discountInfo = $this->discount->getDiscountInfoBy($code);

        if ( is_null($discountInfo) ) { 
            // return 
            //     $error = ['error' => 'Code not available.'];
            // DiscountException::dataNotFoundFor('discount');
            DiscountException::discountError('discount', 'Code not available', 404);
        }

        $result = $this->discount->checkValidityOf($discountInfo, $amount);

        return ($result['isValid'] == true) ? 
            $result['discount_amount'] : 
            DiscountException::discountError('discount', $result['error'], 406);
            

    }

    // protected function getDiscountInfoBy(String $code)
    // {
    //     $discount = Discount::where('code', $code)->first();
    // }

    protected function validateRequest()
    {
        return request()->validate([
            'code' => 'required',
            'amount'   => 'required'
        ]);
    }
}
