<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as PagesDashboard;
use Filament\Pages\Page;

class Dashboard extends PagesDashboard
{
   public function getColumns(): int | string | array
    {
        return 4;
    }
}
