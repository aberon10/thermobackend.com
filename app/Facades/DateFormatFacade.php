<?php
namespace App\Facades;
use Illuminate\Support\Facades\Facade;

class DateFormatFacade extends Facade {
   protected static function getFacadeAccessor() { return 'dateformat'; }
}
