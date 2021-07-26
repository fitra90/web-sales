<?php

namespace App\Http\Controllers;

use App\Models\Stuff;
use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function viewAll(Request $request) {
        if ($request->session()->has('login')) {
            $data = Stuff::all();
            return view('orders', ['data' => $data, 'session' => $request->session()->all()]);
        } else {
            return redirect('/login');
        }
    }
    
    public function viewNew(Request $request) {
        if ($request->session()->has('login')) {
            $menu = Stuff::all();
            return view('new-order', ['menus' => $menu, 'session' => $request->session()->all()]);
        } else {
            return redirect('/login');
        }
    }
}
