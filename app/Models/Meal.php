<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    protected $fillable = ['food_id', 'amount'];

    use HasFactory;
    public function food()
    {
        return $this->belongsTo(Food::class);
    }
}
