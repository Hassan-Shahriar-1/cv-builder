<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory, UsesUuid;
    
    protected $table = 'educations';

    protected $fillable = [
        'user_id',
        'name',
        'school_name',
        'location',
        'feild_of_study',
        'start_date',
        'end_date',
        'active'
    ];
}
