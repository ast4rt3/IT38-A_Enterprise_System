<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkpoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'latitude',
        'longitude',
        'status',
        'schedule',
        'last_collection',
        'next_collection',
        'user_id'
    ];

    protected $casts = [
        'last_collection' => 'datetime',
        'next_collection' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function collections()
    {
        return $this->hasMany(Collection::class);
    }
} 