<?php

namespace App\Filament\Resources\MealResource\Pages;

use App\Filament\Resources\MealResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
class CreateMeal extends CreateRecord
{
    protected static string $resource = MealResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        if ($data['type'] == 'food') {
            return static::getModel()::create($data);
        } else {
            $model;
            foreach ($data['ingredients'] as $ingredient) {
                
                $percentage = $data['ate_weight'] / $data['total_weight'];
                $model = static::getModel()::create([
                    'food_id' => $ingredient['food_id'],
                    'amount' => $ingredient['amount'] * $percentage,
                ]);
            }
            return $model;
        }
    }
}
