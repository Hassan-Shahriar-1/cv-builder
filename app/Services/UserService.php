<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;

class userService 
{

    //default user role
    const USER_ROLE = '32a7370e-4d8d-41ac-90ea-cadf1d3c2cb4';
    //default admin Role
    const ADMIN_ROLE = 'd588c0ff-18a1-4435-8aee-1bf2c0b8179a';

    /**
     * Create User
     * @param array $data
     * @return object
     */
    public function createUser(array $data) : object
    {
        unset($data['confirm_password']);

        $data['password'] = bcrypt($data['password']);

        $checkTrash = User::where('email', $data['email'])->withTrashed()->first();
        
        if($checkTrash) {
            $user = $checkTrash->restore();
            $user->password = $data['password'];
            $user->name = $data['name'];
            $user->updated_at = Carbon::now();
            $user->save();
        } else {  
            $user = User::create($data);
        }
        return $user;
    }
}