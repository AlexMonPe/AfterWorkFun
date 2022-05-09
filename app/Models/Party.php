<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'game_id',
        'user_id'
    ];

    public function users_parties()
    {
        return $this->belongsToMany(User::class, 'users_parties');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function games()
    {
        return $this->belongsTo(Game::class, 'game_id');
    }
}
