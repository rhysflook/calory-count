<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MealResource\Pages;
use App\Filament\Resources\MealResource\RelationManagers;
use App\Models\Meal;
use App\Models\Food;
use App\Models\Recipe;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MealResource extends Resource
{
    protected static ?string $model = Meal::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Radio::make('type')
                    ->label('Type')
                    ->options([
                        'food' => 'Food',
                        'recipe' => 'Recipe',
                    ])->live()->default('food'),
                    // use match to get fields based on type
                Forms\Components\Group::make(fn($get) => match ($get('type')) {
                    'food' => [
                        Forms\Components\Select::make('food_id')
                            ->label('Food')
                            ->required()
                            ->searchable()
                            ->options(Food::all()->pluck('item', 'id')),
                        Forms\Components\TextInput::make('amount')
                            ->label('Amount')
                            ->required()
                            ->numeric()],
                    'recipe' => [
                         Forms\Components\Select::make('recipe_id')
                            ->label('Recipe')
                            ->options(Recipe::all()->pluck('name', 'id'))
                            ->live()
                            ->afterStateUpdated(function ($state, $get, $set) {
                                $recipe = Recipe::find($state);
                                $ingredients = array_map(function($food) {
                                    return [
                                        'food_id' => $food['id'],
                                        'amount' => 0,
                                    ];
                                }, $recipe->foods->toArray());
                                $set('ingredients', $ingredients);
                            }),
                        Forms\Components\Repeater::make('ingredients')
                        ->schema([
                            Forms\Components\Select::make('food_id')
                                ->label('Food')
                                ->required()
                                ->searchable()
                                ->options(Food::all()->pluck('item', 'id')),
                            Forms\Components\TextInput::make('amount')
                                ->label('Amount')
                                ->required()
                                ->numeric(),
                        ]),
                        Forms\Components\TextInput::make('total_weight')
                            ->label('Total Weight')
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('ate_weight')
                            ->label('Ate Weight')
                            ->required()
                            ->numeric(),
                    ],
                })
                // Forms\Components\Select::make('food_id')
                //     ->label('Food')
                //     ->required()
                //     ->searchable()
                //     ->options(Food::all()->pluck('item', 'id')),
                // Forms\Components\TextInput::make('amount')
                //     ->label('Amount')
                //     ->required()
                //     ->numeric(),
                // Forms\Components\TextInput::make('unit')
                //     ->label('Unit')
                //     ->required(),
                // Forms\Components\TextInput::make('calories')
                //     ->label('Calories')
                //     ->required()
                //     ->numeric(),
                // Forms\Components\TextInput::make('protein')
                //     ->label('Protein')
                //     ->required()
                //     ->numeric(),
                // Forms\Components\TextInput::make('fat')
                //     ->label('Fat')
                //     ->required()
                //     ->numeric(),
                // Forms\Components\TextInput::make('carbs')
                //     ->label('Carbs')
                //     ->required()
                //     ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                  TextColumn::make('food.item')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('amount')
                    ->searchable()
                    ->sortable()
                    ->label('Amount')
                    ->formatStateUsing(function($state, $record) {
                        return round($record->amount, 2) . ' ' . $record->food->unit;
                    }),
                // TextColumn::make('food.unit')
                //     ->searchable()
                //     ->label('Unit')
                //     ->sortable(),
                TextColumn::make('food.calories')
                    ->searchable()
                    ->label('Calories')
                    ->sortable()
                    ->formatStateUsing(function($state, $record) {
                        return round($record->food->calories * ($record->amount / $record->food->amount), 2);
                    }),
                TextColumn::make('food.protein')
                    ->searchable()
                    ->label('Protein')
                    ->sortable()
                    ->formatStateUsing(function($state, $record) {
                        return round($record->food->protein * ($record->amount / $record->food->amount), 2);
                    }),
                TextColumn::make('food.fat')
                    ->searchable()
                    ->label('Fat')
                    ->sortable()
                    ->formatStateUsing(function($state, $record) {
                        return round($record->food->fat * ($record->amount / $record->food->amount),2);
                    }),
                TextColumn::make('food.carbs')
                    ->searchable()
                    ->label('Carbohydrates')
                    ->sortable()
                    ->formatStateUsing(function($state, $record) {
                        return round($record->food->carbs * ($record->amount / $record->food->amount), 2);
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])// modify query to only show items with todays date
            ->modifyQueryUsing(fn (Builder $query) => $query->whereDate('created_at', now()));
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMeals::route('/'),
            'create' => Pages\CreateMeal::route('/create'),
            'edit' => Pages\EditMeal::route('/{record}/edit'),
        ];
    }
}
