<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Meal;

class TotalsTable extends Component
{

    #[Reactive]
    public $todays_meals;
    
    public $calories;
    public $protein;
    public $fat;
    public $carbs;
    public $meals;

    public function render()
    {
        $this->calories = 0;
        $this->protein = 0;
        $this->fat = 0;
        $this->carbs = 0;
        $this->meals = [];
        foreach ($this->todays_meals as $meal) {
            $calory_count = $meal->food->calories * ($meal->amount / $meal->food->amount);
            $protein_count = $meal->food->protein * ($meal->amount / $meal->food->amount);
            $fat_count = $meal->food->fat * ($meal->amount / $meal->food->amount);
            $carbs_count = $meal->food->carbs * ($meal->amount / $meal->food->amount);
            $this->meals[] = (object) [
                'item' => $meal->food->item,
                'unit' => $meal->food->unit,
                'amount' => $meal->amount,
                'calories' => $calory_count,
                'protein' => $protein_count,
                'fat' => $fat_count,
                'carbs' => $carbs_count,
            ];
            $this->calories += $calory_count;
            $this->protein += $protein_count;
            $this->fat += $fat_count;
            $this->carbs += $carbs_count;
        }
        return view('livewire.totals-table');
    }
}
