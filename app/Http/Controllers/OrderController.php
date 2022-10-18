<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\Income;
use App\Models\Order;
use App\Models\Order_Group;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // direct order form page
    public function index(){
        $dishes = Dish::orderBy('id','desc')->get();
        $tables = Table::where('avaliable',1)->get();
        $orders = Order_Group::where('status','1')->get();
        return view('order_form',compact('dishes','tables','orders'));
    }

    // add orders
    public function addOrder(Request $request){
        $data = array_filter($request->except('_token','table_id'));
        $table_id = $request->table_id;
        $order_code = rand();
        foreach ($data as $key => $value) {
            if ($value>1) {
                for ($i=0; $i < $value ; $i++) {
                    $this->saveOrder($order_code,$key,$table_id);
                }
            } else {
                $this->saveOrder($order_code,$key,$table_id);
            }
        }
        Table::where('id',$table_id)->update(['avaliable'=>2]);
        $allOrder = Order::where('order_id',$order_code)->get();
        $total = 0;
        foreach ($allOrder as $order) {
            $total += $order->dish->price;
        }
        Order_Group::create([
            'table_id'=>$table_id,
            'total'=> $total,
            'order_id'=>$order_code
        ]);
        return to_route('order#index')->with('success','Your order was received please wait for a while');
    }

    // serve order
    public function serveOrder(Order_Group $id){
        Order::where('order_id',$id->order_id)->delete();
        $id->update(['served'=>'1']);
        return to_route('order#index');
    }

    // billing order
    public function billingOrder(Order_Group $id){
        Income::create(['income'=>$id->total]);
        Table::where('id',$id->table_id)->first()->update(['avaliable'=>'1']);
        $id->delete();
        return to_route('order#index');
    }

    // save order function
    private function saveOrder($para1,$para2,$para3){
        $order = new Order();
        $order->order_id = $para1;
        $order->table_id = $para3;
        $order->dish_id = $para2;
        $order->status = 1;
        $order->save();
    }
}
