<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Meal;
use App\Models\Recipe;

class MealController extends Controller
{
    public function index()
    {
        $foods = Food::all()->pluck('item', 'id')->unique();
        $recipes = Recipe::all()->pluck('name', 'id')->unique();
        $todays_meals = Meal::where('created_at', '>=', now()->startOfDay())->get();
        $calories = 0;
        $protein = 0;
        $fat = 0;
        $carbs = 0;
        $meals = [];
        foreach ($todays_meals as $meal) {
            $calory_count = $meal->food->calories * ($meal->amount / $meal->food->amount);
            $protein_count = $meal->food->protein * ($meal->amount / $meal->food->amount);
            $fat_count = $meal->food->fat * ($meal->amount / $meal->food->amount);
            $carbs_count = $meal->food->carbs * ($meal->amount / $meal->food->amount);
            $meals[] = (object) [
                'item' => $meal->food->item,
                'unit' => $meal->food->unit,
                'amount' => $meal->amount,
                'calories' => $calory_count,
                'protein' => $protein_count,
                'fat' => $fat_count,
                'carbs' => $carbs_count,
            ];
            $calories += $calory_count;
            $protein += $protein_count;
            $fat += $fat_count;
            $carbs += $carbs_count;
        }
        return view('meals', compact('foods', 'todays_meals', 'calories', 'protein', 'fat', 'carbs', 'meals', 'recipes'));
    }

    public function store(Request $request)
    {
        // store to csv with new file for each day using laravel Storage if file created today exists, append to it
        $request->validate([
            'item' => 'required',
            'amount' => 'required',
        ]);
        
        
        $meal = new Meal();
        $meal->food_id = $request->item;
        $meal->amount = $request->amount;
        $meal->save();
        
        return redirect()->route('meals.index');
    }
}
