<?php
namespace App\Http\Resources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
/** @mixin \App\Models\BlogPost */
class BlogPostResource extends JsonResource {
    public function toArray(Request $request): array {
        return [
            'id'          => (string) $this->id,
            'title'       => $this->title,
            'slug'        => $this->slug,
            'excerpt'     => $this->excerpt,
            'content'     => $this->content,
            'thumbnail'   => $this->thumbnail ?? '',
            'author'      => new InstructorResource($this->whenLoaded('author', $this->author)),
            'tags'        => $this->tags ?? [],
            'category'    => $this->category,
            'publishedAt' => $this->published_at?->format('Y-m-d') ?? '',
            'readingTime' => $this->reading_time ?? '',
            'isPublished' => (bool) $this->is_published,
        ];
    }
}
