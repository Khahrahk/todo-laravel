<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'todoId', 'userId', 'created_at', 'updated_at'];

    public function todos()
    {
        return $this->belongsTo(Todo::class, 'todoId', 'id');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }
}
