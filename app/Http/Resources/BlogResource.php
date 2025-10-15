<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
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
            'slug'        => $this->slug,
            'date'        => $this->date,
            'read_time'   => $this->read_time,
            'author'       => $this->author,
            'category'    => $this->category,
            'content'      => $this->content,
            'image'       => url('storage/'.$this->image),
            'excerpt'   => $this->excerpt,
            'featured'    => (bool) $this->featured,
            'created_at'  => $this->created_at?->toDateTimeString(),
            'updated_at'  => $this->updated_at?->toDateTimeString(),
        ];
    }
}
