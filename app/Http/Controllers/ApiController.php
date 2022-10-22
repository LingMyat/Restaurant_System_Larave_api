<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Requests\DishRequest;
use App\Models\Category;
use App\Models\Dish;
use App\Models\Table;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        Dish::create($request->validated());
        return response()->json($request->all(),200);
    }
    //update Dish
    public function updateDish(Dish $id,DishRequest $request){
        $id->update($request->validated());
        return response()->json(['status'=>'success'],200);
    }
    //delete Dish
    public function deleteDish(Dish $id){
        $id->delete();
        return response()->json($id,200);
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
        return response()->json($request->all(),200);
    }
    //delete User
    public function deleteUser(User $id){
        $id->delete();
        return response()->json($id,200);
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
        return response()->json($request->all(),200);
    }
    //update Category
    public function updateCategory(Category $id,CategoryRequest $request){
        $id->update($request->validated());
        return response()->json(['status'=>'success'],200);
    }
    //delete Category
    public function deleteCategory(Category $id){
        $id->delete();
        return response()->json($id,200);
    }
    //tables
    public function tables(){
        $data = Table::all();
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
        return response()->json(['status'=>'success'],200);
    }
}
