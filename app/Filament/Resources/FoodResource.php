<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FoodResource\Pages;
use App\Filament\Resources\FoodResource\RelationManagers;
use App\Models\Food;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FoodResource extends Resource
{
     
    protected static ?string $model = Food::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('item')
                    ->label('Item')
                    ->required(),
                Forms\Components\TextInput::make('amount')
                    ->label('Amount')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('unit')
                    ->label('Unit')
                    ->required(),
                Forms\Components\TextInput::make('calories')
                    ->label('Calories')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('protein')
                    ->label('Protein')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('fat')
                    ->label('Fat')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('carbs')
                    ->label('Carbs')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('item')
                    ->label('Item')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('amount')
                    ->label('Amount'),
                TextColumn::make('unit')
                    ->label('Unit'),
                TextColumn::make('calories')
                    ->label('Calories'),
                TextColumn::make('protein')
                    ->label('Protein'),
                TextColumn::make('fat')
                    ->label('Fat'),
                TextColumn::make('carbs')
                    ->label('Carbs'),
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
            ]);
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
            'index' => Pages\ListFood::route('/'),
            'create' => Pages\CreateFood::route('/create'),
            'edit' => Pages\EditFood::route('/{record}/edit'),
        ];
    }
}
