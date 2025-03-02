<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'value', 'category_id', 'type', 'created_at', 'updated_at'];

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
