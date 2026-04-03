<?php
namespace App\Http\Resources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
/** @mixin \App\Models\CourseLesson */
class CourseLessonResource extends JsonResource {
    public function toArray(Request $request): array {
        return ['id' => (string) $this->id, 'title' => $this->title, 'duration' => $this->duration ?? '', 'videoUrl' => $this->video_url, 'isFree' => (bool) $this->is_free];
    }
}
