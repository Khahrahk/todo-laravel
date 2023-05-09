<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SharedTodo extends Model
{
    use HasFactory;
    protected $fillable = ['fromId','toId', 'created_at', 'updated_at'];

}
