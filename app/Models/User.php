<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, UsesUuid, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'login_type',
        'active'
    ];

    // add this attribute to your model
    protected $refresh_token;

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

    // add this method to set the value of the refresh_token attribute
    public function setRefreshTokenAttribute($value)
    {
        $this->refresh_token = $value;
    }

    public function contact(){
        return $this->hasOne(Contact::class, 'user_id', 'id');
    }

    public function objective(){
        return $this->belongsTo(CareerObjective::class, 'user_id', 'id');
    }

    public function education(){
        return $this->hasMany(Education::class, 'user_id', 'id');
    }

    public function payment(){
        return $this->hasMany(Payment::class, 'user_id', 'id');
    }

    public function project() {
        return $this->hasMany(Project::class, 'user_id', 'id');
    }

    public function skill() {
        return $this->hasMany(Skill::class, 'user_id', 'id');
    }
    
    public function experience() {
        return $this->hasMany(WorkExperience::class, 'user_id', 'id');
    }

    public function subscription() {
        return $this->hasMany(Subscription::class, 'user_id', 'id');
    }
}
