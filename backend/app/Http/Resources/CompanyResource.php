<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'company_name'  => $this->company_name,
            'phone'         => $this->phone,
            'email'         => $this->email,
            'signature_path'=> $this->signature_path,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
            'purposes'      => $this->purposes,
        ];
    }
}
