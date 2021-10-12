<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\SocialController;

class GoogleController extends SocialController
{
    private $driver = 'google';
    
    public function __construct()
    {
        parent::__construct($this->driver);
    }
}
