<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Goal;

class HomeController extends Controller
{
    /**
     * @return view
     */
    public function home ()
    {
        $items = Goal::where('userid', '=', '9')->get();
        // dd($items);
        return view('home', compact('items'));
    }
}
