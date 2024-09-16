<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FoodDrinkController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\RecipeController;
use App\Livewire\MealInputContainer;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('foods', FoodDrinkController::class);
// Route::resource('', );
Route::get('meals', MealInputContainer::class);
Route::resource('recipes', RecipeController::class);
