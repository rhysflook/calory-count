<?php

namespace App\Filament\Widgets;

use App\Models\Meal;
use Illuminate\Support\Facades\DB;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class CaloryChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'caloryChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'CaloryChart';
    protected int | string | array $columnSpan = 'full';
    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        // $calory_count = $meal->food->calories * ($meal->amount / $meal->food->amount);
         $calories = Meal::query()->select(DB::raw('SUM(f.calories::double precision * (meals.amount / f.amount::double precision)) as calories'), DB::raw('DATE(meals.created_at) as created_at'))
            ->leftJoin('food as f', 'f.id', 'meals.food_id')
            ->groupBy(DB::raw('DATE(meals.created_at)'))
            ->orderBy('created_at')
            ->get();

        $dates = $calories->pluck('created_at')->toArray();
        $dates = array_map(function ($date) {
            return date('Y/m/d', strtotime($date));
        }, $dates);
        return [
            'chart' => [
                'type' => 'line',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'CaloryChart',
                    'data' => $calories->pluck('calories')->toArray(),
                    'color' => '#4248f5'
                ],
            ],
            'xaxis' => [
                'categories' => $dates,
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
                'decimalsInFloat' => 0
            ],
            'colors' => ['#f59e0b'],
            'stroke' => [
                'curve' => 'smooth',
            ],
        ];
    }
}
