<?php

namespace App\Exception;

use Exception;

class UserMustBeLoggedIn extends Exception
{

    /**
     * UserMustBeLoggedIn constructor.
     */
    public function __construct()
    {
        parent::__construct('You must be logged-in');
    }
}
