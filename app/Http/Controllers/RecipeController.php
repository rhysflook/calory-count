<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Recipe;

class RecipeController extends Controller
{
    public function index()
    {
        $foods = Food::all();
        return view('recipes', compact('foods'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required', 
            'item' => 'required',
        ]);
        
        $recipe = new Recipe();
        $recipe->name = $request->name;

        $recipe->save();

        foreach ($request->item as $item) {
            $recipe->foods()->attach($item);
        }
        
        return redirect()->route('recipes.index');
    }
}
