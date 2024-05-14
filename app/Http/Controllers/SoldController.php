<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Sold;
use Carbon\Carbon;

use Illuminate\Http\Request;

class SoldController extends Controller
{
    public function show(){
        $userId = Auth::id();
    
        // Retrieve sold items associated with the current user
        $Sold = Sold::where('user_id', $userId)->get();
    
        // Calculate weekly and monthly sales
        $weeklySales = Sold::where('user_id', $userId)
        ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
        ->sum('product_price');

    $monthlySales = Sold::where('user_id', $userId)
        ->whereMonth('created_at', now()->month)
        ->sum('product_price');

    
        // You can pass $soldItems, $weeklySales, and $monthlySales to your view or process them further as needed
        return view('Sold', ['Sold' => $Sold, 'weeklySales' => $weeklySales, 'monthlySales' => $monthlySales]);
    }
    
}
