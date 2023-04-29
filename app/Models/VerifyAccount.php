<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifyAccount extends Model
{
    use HasFactory, UsesUuid;
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'verify_token',
        'expire'
    ];

    /**
     * creating verify url for account verification
     */
    public function getVerifyUrlAttribute()
    {
        $request = request();
        $protocol = $request->getScheme();
        $host = $request->getHost();
        return $protocol . '://' . $host . '/?token='.$this->verify_token;
    }
}
