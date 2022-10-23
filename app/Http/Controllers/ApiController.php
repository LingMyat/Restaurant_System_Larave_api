<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\User;
use App\Models\Order;
use App\Models\Table;
use App\Models\Income;
use App\Models\Category;
use App\Models\Order_Group;
use Illuminate\Http\Request;
use App\Http\Requests\DishRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Storage;

class ApiController extends Controller
{
    //Dishes
    public function dishes(){
        $data = Dish::all();
        return response()->json($data,200);
    }
    //show Dish
    public function showDish(Dish $id){
        return response()->json($id,200);
    }
    //create Dish
    public function createDish(DishRequest $request){
        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $imgName = uniqid().$request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public',$imgName);
            $validated['image'] = $imgName;
        }
        Dish::create($validated);
        return response()->json($request->all(),201);
    }
    //update Dish
    public function updateDish(Dish $id,DishRequest $request){
        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $imgName = uniqid().$request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public',$imgName);
            $validated['image'] = $imgName;
            if($id->image != Null){
                Storage::delete('public/'.$id->image);
            }
        } else {
            $validated['image'] = $id->image;
        }
        $id->update($validated);
        return response()->json(['status'=>'success'],201);
    }
    //delete Dish
    public function deleteDish(Dish $id){
        $id->delete();
        return response()->json($id,204);
    }
    //users
    public function users(){
        $data = User::all();
        return response()->json($data,200);
    }
    //show User
    public function showUser(User $id){
        return response()->json($id,200);
    }
    //create User
    public function createUser(Request $request){
        User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)
        ]);
        return response()->json($request->all(),201);
    }
    //delete User
    public function deleteUser(User $id){
        $id->delete();
        return response()->json($id,204);
    }
    //categories data
    public function categories(){
        $data = Category::all();
        return response()->json($data,200);
    }
    //show Category
    public function showCategory(Category $id){
        return response()->json($id,200);
    }
    //create Category
    public function createCategory(CategoryRequest $request){
        Category::create($request->validated());
        return response()->json($request->all(),201);
    }
    //update Category
    public function updateCategory(Category $id,CategoryRequest $request){
        $id->update($request->validated());
        return response()->json(['status'=>'success'],201);
    }
    //delete Category
    public function deleteCategory(Category $id){
        $id->delete();
        return response()->json($id,204);
    }
    //tables
    public function tables(){
        $data = Table::all();
        return response()->json($data,200);
    }
    //avaliable Table
    public function avaliableTable(){
        $data = Table::where('avaliable','1')->get();
        return response()->json($data,200);
    }
    //add Tables
    public function addTables(Request $request){
        $table = Table::orderBy('id', 'desc')->first();
        $currentTable = $table->name;
        for ($i=0; $i < $request->qty ; $i++) {
            $currentTable += 1;
            Table::create(['name'=>$currentTable]);
        };
        return response()->json(['status'=>'success'],201);
    }
    //orders
    public function orders(){
        $data = Order::all();
        return response()->json($data,200);
    }
    //order Groups
    public function orderGroup(){
        $data = Order_Group::all();
        return response()->json($data,200);
    }
    //add Order
    public function addOrder(Request $request){
        $data = $request->except('table_id');
        $table_id = $request->table_id;
        $order_id = rand();
        foreach ($data as $key => $value) {
            if ($value > 1) {
                for ($i=0; $i < $value; $i++) {
                    $this->saveOrder($order_id,$key,$table_id);
                }
            } else {
                $this->saveOrder($order_id,$key,$table_id);
            }
        }
        Table::where('id',$table_id)->update(['avaliable'=>2]);
        $allOrder = Order::where('order_id',$order_id)->get();
        $total = 0;
        foreach ($allOrder as $order) {
            $total += $order->dish->price;
        }
        Order_Group::create([
            'table_id'=>$table_id,
            'total'=> $total,
            'order_id'=>$order_id
        ]);
        return response()->json(['status'=>'success'],201);
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
    //ready Order
    public function readyOrder(Request $request){
        Order_Group::where('order_id',$request->order_id)->update(['status'=>1]);
        return response()->json(['status'=>'success'],201);
    }
    //serve Order
    public function serveOrder(Request $request){
        Order_Group::where('order_id',$request->order_id)->update(['served'=>1]);
        Order::where('order_id',$request->order_id)->delete();
        return response()->json(['status'=>'success'],201);
    }
    //billing Order
    public function billingOrder(Request $request){
        $data = Order_Group::where('order_id',$request->order_id)->first();
        Income::create(['income'=>$data->total]);
        Table::where('id',$data->table_id)->first()->update(['avaliable'=>'1']);
        $data->delete();
        return response()->json(['status'=>'success'],204);
    }
}
