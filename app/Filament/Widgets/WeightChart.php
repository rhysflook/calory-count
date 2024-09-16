<?php

namespace App\Filament\Widgets;

use App\Models\Meal;
use Illuminate\Support\Facades\DB;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class WeightChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'weightChart';
    protected int | string | array $columnSpan = 'full';
    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'WeightChart';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $weights = \App\Models\Weight::all();
        $data = $weights->pluck('weight')->toArray();

        $dates = $weights->pluck('created_at')->toArray();

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
                    'name' => 'Weight',
                    'data' => $data,
                ],
                // [
                //     'name' => 'Calories',
                //     'data' => $calories,
                // ],
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
            'colors' => ['#f59e0b', '#33ceff'],
            'stroke' => [
                'curve' => 'smooth',
            ],
        ];
    }
}
