<?php

namespace App\Http\Controllers;

use App\Models\Stuff;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function viewAll(Request $request)
    {
        if ($request->session()->has('login')) {
            $order = DB::table('orders')->paginate(5);
            return view('orders', ['data' => $order, 'session' => $request->session()->all()]);
        } else {
            return redirect('/login');
        }
    }

    public function viewNew(Request $request)
    {
        if ($request->session()->has('login')) {
            $menu = Stuff::all();
            return view('new-order', ['menus' => $menu, 'session' => $request->session()->all()]);
        } else {
            return redirect('/login');
        }
    }

    public function lastOrder()
    {
        $data = DB::table('orders')->latest('idorders')->first();
        return Response(["data" => $data], 200);
    }

    public function saveNew(Request $request)
    {
        $input = $request->input();
        $data = json_decode($input['data']);
        $arrCount = count($data);
        $noMeja = $data[$arrCount - 1]->noMeja;
        $orderCodeNo = $data[$arrCount - 1]->orderCodeNo + 1;
        $orderCode = 'ABC' . date('dmY') . "-" . $orderCodeNo;
        $order = new Order;
        $orderItem = new OrderItem;
        //save order 
        $order->order_code = $orderCode;
        $order->table_number = $noMeja;
        $order->is_paid = 0;
        $order->created_by = session('user_id');
        $order->status = 1;
        $order->save();
        $orderId = $order->id;

        for ($i = 0; $i < ($arrCount - 1); $i++) {
            //save order item
            $orderItem->order_id = $orderId;
            $orderItem->stuff_id = $data[$i]->id;
            $orderItem->amount = $data[$i]->id;
            $orderItem->save();
        }

        return redirect('/orders');
    }

    public function delete($id)
    {
        $data  = DB::table('orders')->where('idorders', '=', $id)->delete();
        $data  = DB::table('order_items')->where('order_id', '=', $id)->delete();
        if ($data) {
            return true;
        } else {
            return false;
        }
    }
}
