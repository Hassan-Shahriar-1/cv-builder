<?php

namespace App\Services;

use App\Mail\VerificationMail;
use App\Models\User;
use App\Models\VerifyAccount;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserService 
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
            $verificationData = $this->storeVerificationToken($user);
            $this->verificationMailSending($user->email, $verificationData->verify_url);
        }
        return $user;
    }

    /**
     * Store verification token
     * @param object $user
     * @return object $verificationtoken
     */
    public function storeVerificationToken(object $user) :object
    {
        $data = [];
        $data['user_id'] = $user->id;
        $data['verify_token'] = Str::random(64);
        $data['expire'] = Carbon::now()->addMinutes(60);
        return VerifyAccount::create($data);
    }

    /**
     * Account verification mail send
     * @param string $email
     * @param string $verifyurl
     * @return void
     */
    public function verificationMailSending(string $email, string $verifyUrl) : void
    {
        Mail::to($email)->send(new VerificationMail($verifyUrl));
    }

    /**
     * update profile data
     * @param $prodileData
     * @return void
     */
    public function updateProfile(array $prodileData): void
    {
        User::where('id', $prodileData['id'])->update($prodileData);
    }
}