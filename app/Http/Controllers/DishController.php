<?php

namespace App\Http\Controllers;

use App\Http\Requests\DishRequest;
use App\Models\Dish;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DishController extends Controller
{
    // direct dish page
    public function index(){
        $dishes = Dish::all();
        return view('Kitchen.dish',compact('dishes'));
    }

    // dish create dish page
    public function createDishPage(){
        $categories = Category::all();
        return view('Kitchen.createDish',compact('categories'));
    }

    // create dish
    public function createDish(DishRequest $request){
        $validated = $request->validated();
        $imgName = uniqid().$request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('public',$imgName);
        $validated['image']=$imgName;
        Dish::create($validated);
        return to_route('dish#index');
    }

    // edit dish page
    public function editDishPage(Dish $id){
        $categories = Category::all();
        return view('Kitchen.editDish',['data'=>$id,'categories'=>$categories]);
    }

    // update dish page
    public function updateDish(Dish $id,DishRequest $request){
        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $imgName = uniqid().$request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public',$imgName);
            $validated['image']=$imgName;
            if ($id->image !== Null) {
                Storage::delete('public/'.$id->image);
            }
        } else {
            $validated['image']=$id->image;
        }
        $id->update($validated);
        return to_route('dish#index');
    }

    // dish delete
    public function dishDelete(Dish $id){
        $id->delete();
        return to_route('dish#index');
    }
}
