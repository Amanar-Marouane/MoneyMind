<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'value', 'created_at', 'updated_at'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
