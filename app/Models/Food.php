<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class Food extends Model
{
    use HasFactory;

    protected $fillable = [
        'item',
        'amount',
        'unit',
        'calories',
        'protein',
        'fat',
        'carbs',
    ];
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    public function recipes()
    {
        return $this->belongsToMany(Recipe::class);
    }
}
