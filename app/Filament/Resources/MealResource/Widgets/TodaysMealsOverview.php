<?php

namespace App\Filament\Resources\MealResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Meal;
class TodaysMealsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // sum aggregate calories from meals created today via food relationship
        $meals = Meal::whereDate('created_at', now()->toDateString())->get();
        $this->calories = 0;
        $this->protein = 0;
        $this->fat = 0;
        $this->carbs = 0;
        $this->meals = [];
        foreach ($meals as $meal) {
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

        return [
            Stat::make('Total calories', round($this->calories, 2)),
            Stat::make('Total protein', round($this->protein, 2)),
            Stat::make('Total fat', round($this->fat, 2)),
            Stat::make('Total carbohydrates', round($this->carbs, 2)),
        ];
    }
}
