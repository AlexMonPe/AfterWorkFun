<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $table = 'messages';

    protected $fillable = [
        'message',
        'user_id',
        'party_id'
    ];

    public function parties()
    {
        return $this->belongsTo(Party::class, 'party_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
