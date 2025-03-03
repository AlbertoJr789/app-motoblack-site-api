<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PassageiroResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->pessoa->nome,
            'user_id' => $this->user_id,
            'avatar' => str_contains($this->user->profile_photo_url, 'ui-avatars') ? null : $this->user->profile_photo_path,
        ];
    }
}
