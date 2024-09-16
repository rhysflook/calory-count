<?php

namespace App\Filament\Widgets;

use App\Models\Meal;
use Illuminate\Support\Facades\DB;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class MacrosChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'macrosChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'MacrosChart';
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
         $macros = Meal::query()->select(
            DB::raw('SUM(f.protein * (meals.amount / f.amount::double precision)) as protein'),
            DB::raw('SUM(f.carbs * (meals.amount / f.amount::double precision)) as carbs'),
            DB::raw('SUM(f.fat * (meals.amount / f.amount::double precision)) as fat'),
            DB::raw('DATE(meals.created_at) as created_at'))
            ->leftJoin('food as f', 'f.id', 'meals.food_id')
            ->groupBy(DB::raw('DATE(meals.created_at)'))
            ->orderBy('created_at')
            ->get();

        $dates = $macros->pluck('created_at')->toArray();
        $dates = array_map(function ($date) {
            return date('Y/m/d', strtotime($date));
        }, $dates);
        return [
            'chart' => [
                'type' => 'line',
                'height' => 300,
            ],
            'colors' => ['#2E93fA', '#66DA26', '#546E7A'],
            'series' => [
                [
                    'name' => 'Protein',
                    'data' => $macros->pluck('protein')->toArray(),
                    'color' => '#ad5ac7',
                ],
                [
                    'name' => 'Carbohydrates',
                    'data' => $macros->pluck('carbs')->toArray(),
                    'color' => '#66DA26',
                ],
                [
                    'name' => 'Fat',
                    'data' => $macros->pluck('fat')->toArray(),
                    'color' => '#f55742',
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
            ],
            'colors' => ['#f59e0b'],
            'stroke' => [
                'curve' => 'smooth',
            ],
        ];
    }
}
