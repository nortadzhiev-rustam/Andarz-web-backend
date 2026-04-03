<?php
namespace App\Http\Requests\Blog;
use Illuminate\Foundation\Http\FormRequest;
class UpdateBlogPostRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        $id = $this->route('blog');
        return [
            'title'        => ['sometimes','required','string','max:255'],
            'slug'         => ['nullable','string','max:255',"unique:blog_posts,slug,{$id}"],
            'excerpt'      => ['sometimes','required','string'],
            'content'      => ['sometimes','required','string'],
            'thumbnail'    => ['nullable','string'],
            'author_id'    => ['sometimes','integer','exists:instructors,id'],
            'tags'         => ['nullable','array'],
            'tags.*'       => ['string'],
            'category'     => ['sometimes','string'],
            'published_at' => ['nullable','date'],
            'reading_time' => ['nullable','string'],
            'is_published' => ['boolean'],
        ];
    }
}
