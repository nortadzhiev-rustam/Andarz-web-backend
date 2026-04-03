<?php
namespace App\Http\Requests\Blog;
use Illuminate\Foundation\Http\FormRequest;
class StoreBlogPostRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'title'        => ['required','string','max:255'],
            'slug'         => ['nullable','string','max:255','unique:blog_posts'],
            'excerpt'      => ['required','string'],
            'content'      => ['required','string'],
            'thumbnail'    => ['nullable','string'],
            'author_id'    => ['required','integer','exists:instructors,id'],
            'tags'         => ['nullable','array'],
            'tags.*'       => ['string'],
            'category'     => ['required','string'],
            'published_at' => ['nullable','date'],
            'reading_time' => ['nullable','string'],
            'is_published' => ['boolean'],
        ];
    }
}
