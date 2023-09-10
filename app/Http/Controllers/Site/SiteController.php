<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function plansPrices()
    {
        return view('plans-prices');
    }
}
