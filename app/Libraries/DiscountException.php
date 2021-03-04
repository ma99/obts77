<?php

namespace App\Libraries;

use App\Exceptions\DiscountRelatedException;

class DiscountException
{
    public static function discountError(String $error, String $message, $code)
    {
      throw new DiscountRelatedException($error, $message, $code);
    }
}