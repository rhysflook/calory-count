<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Food;
use App\Models\Recipe;
use App\Models\Meal;

class MealInputContainer extends Component
{

    public $todays_meals;

    public $foods;
    public $recipes;
 

    public $type;
    public $item;
    public $amount;
    public $recipe;
    public $ingredients = [];
    public $total_weight;
    public $ate_weight;

    public $items = [];
    public $amounts = [];

    public function mount()
    {
        $this->foods = Food::all()->pluck('item', 'id')->unique();
        $this->recipes = Recipe::all()->pluck('name', 'id')->unique();
        $this->todays_meals = Meal::where('created_at', '>=', now()->startOfDay())->get();
        
        $this->type = 'item';
    }

    public function getRecipe()
    {
        $this->ingredients = Recipe::find($this->recipe)->foods->pluck('item', 'id')->unique()->toArray();
        $this->items = array_map(fn ($ingredient) => $ingredient, array_keys($this->ingredients));
        $this->amounts = array_fill(0, count($this->ingredients), 0);
    }

    public function updateIngredients($index, $value)
    {
        $food = Food::find($value);
        $this->ingredients[$index] = $food->item;
        $this->items[$index] = $food->id;
    }

    public function updateAmounts($index, $value)
    {
        $this->amounts[$index] = $value;
    }

    public function addEntry()
    {
        if ($this->type === 'item') {
        //     $request->validate([
        //     'item' => 'required',
        //     'amount' => 'required',
        // ]);
        
            $meal = new Meal();
            $meal->food_id = $this->item;
            $meal->amount = $this->amount;
            $this->item = '';
            $this->amount = '';
            $meal->save();
        } else {
            $percentage = $this->ate_weight / $this->total_weight;
            foreach ($this->items as $index => $id) {
                $meal = new Meal();
                $meal->food_id = $id;
                $meal->amount = $this->amounts[$index] * $percentage;
                $meal->save();
            }
        }
        $this->mount();
    }

    public function render()
    {
        return view('livewire.meal-input-container');
    }
}
