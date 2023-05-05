<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SharedTodo extends Model
{
    use HasFactory;
    protected $fillable = ['toId', 'fromId', 'created_at', 'updated_at'];
    public function sharedTodo()
    {
        return $this->belongsTo(User::class);
    }
}
