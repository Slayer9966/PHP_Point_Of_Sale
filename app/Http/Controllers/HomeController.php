<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
   
    public function show(){
        $user = auth()->user();

    // Retrieve only the data for the authenticated user
    $Data = Products::where('user_id', $user->id)->get();

    return view('cashier', compact('Data'));
    }
    public function logout(){
        return redirect()->back();
    }
}
