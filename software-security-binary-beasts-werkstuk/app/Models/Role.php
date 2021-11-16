<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * @mixin Builder
 */

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['role_name','role_description'];


    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    
}
