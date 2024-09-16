<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;

class FoodDrinkController extends Controller
{
    public function index()
    {
        return view('food-input');
    }

    public function store(Request $request)
    {

        $request->validate([
            'item' => 'required',
            'amount' => 'required',
            'unit' => 'required',
            'calories' => 'required',
            'protein' => 'required',
            'fat' => 'required',
            'carbs' => 'required',
        ]);

        $food = new Food();
        $food->item = $request->item;
        $food->amount = $request->amount;
        $food->unit = $request->unit;
        $food->calories = $request->calories;
        $food->protein = $request->protein;
        $food->fat = $request->fat;
        $food->carbs = $request->carbs;
        $food->save();
        return redirect()->route('foods.index');
    }

    // public function foods()
    // {
    //     return view('foods');
    // }

    // public function drinks()
    // {
    //     return view('drinks');
    // }

    // public function meals()
    // {
    //     return view('meals');
    // }
}
