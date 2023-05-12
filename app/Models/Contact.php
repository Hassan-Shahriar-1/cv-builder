<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory, UsesUuid;

    protected $fillable = [
        'first_name',
        'last_name',
        'user_id',
        'email',
        'job_title',
        'phone',
        'location',
        'linkedin_link',
        'facebook_link',
        'twitter_link',
        'website'
    ];
}
