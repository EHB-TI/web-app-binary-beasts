<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'date',
    ];

    public function members()
    {
        return $this->belongsToMany(User::class);
    }
    public function admin()
    {
        return $this->belongsTo(User::class);
    }
}
