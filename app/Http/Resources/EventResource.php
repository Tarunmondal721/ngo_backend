<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'date'        => $this->date,
            'time'        => $this->time,
            'location'    => $this->location,
            'category'    => $this->category,
            'description' => $this->description,
            'image'       => url('storage/'.$this->image),
            'attendees'   => $this->attendees,
            'impact'      => $this->impact,
            'status'      => $this->status,
            'price'       => $this->price,
            'featured'    => (bool) $this->featured,
            'created_at'  => $this->created_at?->toDateTimeString(),
            'updated_at'  => $this->updated_at?->toDateTimeString(),
        ];
    }
}
