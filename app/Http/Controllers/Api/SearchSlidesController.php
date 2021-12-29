<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\DataNotFoundException;
use App\Http\Controllers\Controller;
use App\Libraries\DataException;
use Illuminate\Http\Request;
use App\Slide;


class SearchSlidesController extends Controller
{
    private $slide;

    public function __construct(Slide $slide)
    {
        $this->slide = $slide;
    }
      
   public function index()
   {   
        $slides = Slide::all();

         if (!count($slides)) {
          DataException::dataNotFoundFor('slide');
        }
        return $this->slide->detailsOf($slides);
   }    

   public function slides()
   {   
        $slides = $this->slide->activeSlides();

         if (!count($slides)) {
          DataException::dataNotFoundFor('slide');
        }
        return $this->slide->detailsOf($slides);
   }
}
