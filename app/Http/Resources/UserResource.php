<?php

namespace App\Http\Resources;

use App\Services\userService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'role' => $this->user_type == userService::USER_ROLE ? 'user' : 'admin',
            'login_type' => $this->login_type ? $this->login_type : 'default',
            'active' => $this->active ? $this->active : false,
            'deleted_at' => $this->deleted_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
