<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'created_at', 'updated_at'];

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function expensesSum()
    {
        return $this->expenses()->sum('cost');
    }
}
