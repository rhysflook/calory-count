<?php

namespace App\Filament\Resources\MealResource\Pages;

use App\Filament\Resources\MealResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\MealResource\Widgets\TodaysMealsOverview;
class ListMeals extends ListRecords
{
    protected static string $resource = MealResource::class;
    
    protected function getHeaderWidgets(): array
    {
        return [
            TodaysMealsOverview::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    
}
