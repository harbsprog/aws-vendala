<?php

namespace App\Http\Controllers;

class MeliController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function sendSQS()
    {
        dd('funcionando');
    }
}
