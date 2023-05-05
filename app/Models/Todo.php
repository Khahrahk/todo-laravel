<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'body', 'is_active', 'image', 'user', 'created_at', 'updated_at'];
    public function tags()
    {
        return $this->hasMany(Tag::class, 'todoId', 'id');
    }
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
