<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Table;
use App\Models\Category;
use App\Models\Order_Group;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;

class KitchenController extends Controller
{
    public function orderList(){
        $orders = Order_Group::where('status','0')->get();
        return view('Kitchen.home',compact('orders'));
    }

    public function orderDetail(Order_Group $id){
        $dishes = Order::where('order_id',$id->order_id)->get();
        return view('Kitchen.orderDetail',compact('dishes'));
    }

    public function orderReady(Order_Group $id){
        $id->update(['status'=>'1']);
        return to_route('kitchen#orderList');
    }

    public function orderCancel(Order_Group $id){
        Order::where('order_id',$id->order_id)->delete();
        Table::where('id',$id->table_id)->first()->update(['avaliable'=>'1']);
        $id->delete();
        return to_route('kitchen#orderList');
    }

    public function categoryList(){
        $categories = Category::all();
        return view('Kitchen.categoryList',compact('categories'));
    }

    public function categoryCreate(CategoryRequest $request){
        Category::create($request->validated());
        return to_route('kitchen#categoryList');
    }

    public function categoryUpdate(Request $request){
        Category::where('id',$request->id)->update(['name'=>$request->name]);
        return response()->json(['status'=>'success'],200);
    }

    public function categoryDelete(Category $id){
        $id->delete();
        return to_route('kitchen#categoryList');
    }

    public function addTables(Request $request){
        $table = Table::orderBy('id', 'desc')->first();
        $currentTable = $table->name;
        for ($i=0; $i < $request->qty ; $i++) {
            $currentTable += 1;
            Table::create(['name'=>$currentTable]);
        };
        return response()->json(['status'=>'success'],200);
    }
}
