<?php
namespace App\Http\Resources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
/** @mixin \App\Models\Course */
class CourseResource extends JsonResource {
    public function toArray(Request $request): array {
        return [
            'id'               => (string) $this->id,
            'title'            => $this->title,
            'slug'             => $this->slug,
            'description'      => $this->description,
            'shortDescription' => $this->short_description,
            'thumbnail'        => $this->thumbnail ?? '',
            'price'            => (float) $this->price,
            'discountPrice'    => $this->discount_price !== null ? (float) $this->discount_price : null,
            'level'            => $this->level,
            'category'         => $this->category,
            'tags'             => $this->tags ?? [],
            'instructor'       => new InstructorResource($this->whenLoaded('instructor', $this->instructor)),
            'modules'          => CourseModuleResource::collection($this->whenLoaded('modules', $this->modules)),
            'duration'         => $this->duration ?? '',
            'studentsCount'    => (int) $this->students_count,
            'rating'           => (float) $this->rating,
            'reviewsCount'     => (int) $this->reviews_count,
            'language'         => $this->language,
            'lastUpdated'      => $this->last_updated?->format('Y-m-d') ?? '',
            'isPublished'      => (bool) $this->is_published,
            'isFeatured'       => (bool) $this->is_featured,
        ];
    }
}
