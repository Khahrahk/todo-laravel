<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


/**
 * @property int $id
 */

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sentTo()
    {
        return $this->hasMany(SharedTodo::class, 'toId', 'id');
    }

    public function sentFrom()
    {
        return $this->hasMany(SharedTodo::class, 'fromId', 'id');
    }

    public function sharedTodo()
    {
        return $this->sentTo()->union($this->sentFrom()->toBase());
    }

    public function todos()
    {
        return $this->hasMany(Todo::class, 'user', 'id');
    }

    public function getId()
    {
        return $this->id;
    }
}
