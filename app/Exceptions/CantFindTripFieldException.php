<?php

namespace App\Exceptions;

class CantFindTripFieldException extends \Exception
{
   public function __toString()
   {
      __toString("Can't get from/to if a trip has no parts");
   }
}
