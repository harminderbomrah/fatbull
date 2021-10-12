<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\SocialController;

class FacebookController extends SocialController
{
    private $driver = 'facebook';

    public function __construct()
    {
        parent::__construct($this->driver);
    }
}
