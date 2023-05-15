<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory, UsesUuid;

    protected $table = 'projects';

    protected $fillable = [
        'user_id',
        'title',
        'role',
        'start_date',
        'end_date',
        'details'
    ];
}
