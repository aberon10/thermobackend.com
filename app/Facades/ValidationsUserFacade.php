<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ValidationsUserFacade extends Facade {
   protected static function getFacadeAccessor() { return 'validations_user'; }
}
