<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'github_id',
        'auth_type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function events()
    {
        return $this->belongsToMany(Event::class);
    }

    public function hosting()
    {
        return $this->hasMany(Event::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    public function groupAdmin()
    {
        return $this->hasMany(Group::class);
    }

    public static function search($search){
        // This static function is used to create the dynamic users table livewire component
        // We check if the value is empty first, otherwise we query the db with the input text
        // where and orWhere sanitize inputs so no SQL injection is possible here
        return empty($search) ? static::query()->whereHas("roles", function ($q){
            $q->where("role_name", "STUDENT");
        })
            : static::query()->where('id', 'like', '%'.$search.'%')->whereHas("roles", function ($q){
                $q->where("role_name", "STUDENT");
            })
            ->orWhere("name", "like", "%".$search."%")->whereHas("roles", function ($q){
                $q->where("role_name", "STUDENT");
            })
            ->orWhere('email', 'like', '%'.$search.'%')->whereHas("roles", function ($q){
                $q->where("role_name", "STUDENT");
            });
    }
}