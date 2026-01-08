<?php

namespace App\Http\Controllers;

class MainSiteController extends Controller
{
    public function home()
    {
        return view('main.home');
    }

    public function about()
    {
        return view('main.about');
    }
}
