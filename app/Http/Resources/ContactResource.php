<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'event'     => $this->event,
            'email'     => $this->email,
            'phone'     => $this->phone,
            'message'   => $this->message,
            'subject'   => $this->subject,
            'type'      => $this->type,
            'status'    => (bool) $this->status,
            'created_at'=> $this->created_at?->toDateTimeString(),
            'updated_at'=> $this->updated_at?->toDateTimeString(),
        ];
    }
}
