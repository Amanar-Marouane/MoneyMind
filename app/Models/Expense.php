<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $fillable = ["name", "cost", "category_id", "starting_date", "monthly", "user_id"];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
