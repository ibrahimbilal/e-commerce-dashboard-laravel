<?php

namespace App\Http\Controllers;

class TwoFactorPageController extends Controller
{
    public function recovery()
    {
        return view('auth.two-factor-recovery');
    }
}
