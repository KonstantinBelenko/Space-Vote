<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class testflare extends Controller
{
    public function index(string $int)
    {
        // convert string to int
        $int = (int) $int;
        // divide by zero
        $int = 1 / $int;
        // return the result
        return $int;
    }
}
