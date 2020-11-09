<?php

namespace App\Libraries;

use App\Exceptions\DataNotFoundException;

class DataException
{
    public static function dataNotFoundFor(String $str)
    {
      throw new DataNotFoundException($str);
    }
}