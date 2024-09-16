<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TodaysWeightOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // get todays wiehgt
        $todaysWeight = \App\Models\Weight::whereDate('created_at', now())->first();
        return [
            Stat::make('Weight', $todaysWeight ? $todaysWeight->weight : 'You have not entered your weight today'),
        ];
    }
}
