<?php

namespace App\Http\Resources;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'user_type' => $this->user_type == UserService::USER_ROLE ? 'User' : 'Admin',
            'login_type' => $this->login_type,
            'dob' => $this->dob,
            $this->mergeWhen($this->user_type == UserService::ADMIN_ROLE, function(){
                return [
                    'social_id' => $this->social_id,
                ];
            }),
            'phone' => $this->phone,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at
            
        ];
    }
}
