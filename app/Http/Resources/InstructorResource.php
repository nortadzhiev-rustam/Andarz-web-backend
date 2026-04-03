<?php
namespace App\Http\Resources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
/** @mixin \App\Models\Instructor */
class InstructorResource extends JsonResource {
    public function toArray(Request $request): array {
        return ['id' => (string) $this->id, 'name' => $this->name, 'avatar' => $this->avatar ?? '', 'bio' => $this->bio ?? ''];
    }
}
