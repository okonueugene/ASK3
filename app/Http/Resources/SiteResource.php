<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SiteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $owner = User::find($this->user_id);
        $company = Company::find($this->company_id);

        return [
            'id' => $this->id,
            'company' => $company->company_name,
            'name' => $this->name,
            'location' => $this->location,
            'lat' => $this->lat,
            'long' => $this->long,
            'user' => $owner->name,
            'timezone' => $this->timezone,
            'country' => $this->country,

        ];
    }
}
