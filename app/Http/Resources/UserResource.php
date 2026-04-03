<?php
namespace App\Http\Resources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
/** @mixin \App\Models\User */
class UserResource extends JsonResource {
    public function toArray(Request $request): array {
        return [
            'id'              => (string) $this->id,
            'name'            => $this->name,
            'email'           => $this->email,
            'avatar'          => $this->avatar,
            'role'            => $this->role,
            'enrolledCourses' => $this->whenLoaded('enrolledCourses', fn() => $this->enrolledCourses->pluck('id')->map(fn($id) => (string)$id)->values()->toArray(), []),
            'createdAt'       => $this->created_at?->toISOString(),
        ];
    }
}
