<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    use HasFactory, UsesUuid;

    protected $fillable = [
        'company_name',
        'user_id',
        'job_title',
        'location',
        'start_date',
        'end_date',
        'active',
        'responsibilities'
    ];
}
