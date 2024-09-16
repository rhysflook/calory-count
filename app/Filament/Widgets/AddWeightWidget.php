<?php

namespace App\Filament\Widgets;

use App\Models\Weight;
use Filament\Widgets\Widget;

class AddWeightWidget extends Widget
{
    protected int | string | array $columnSpan = 1;
    public $inputWeight;
     /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        $weight = Weight::whereDate('created_at', now())->first();
        return ['weight' => $weight];
    }
    protected static string $view = 'filament.widgets.add-weight-widget';

    public function addWeight()
    {
       Weight::create([
           'weight' => floatval($this->inputWeight),
       ]);
    }
}
