<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExperienceResource extends JsonResource
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
            'company_name' => $this->company_name,
            'start_date' => $this->start_date,
            'title' => $this->job_title,
            'location' => $this->location,
            'responsibilities' => $this->responsibilities,
            'end_date' => $this->end_date,
            'active' => $this->active
        ];
    }
}
