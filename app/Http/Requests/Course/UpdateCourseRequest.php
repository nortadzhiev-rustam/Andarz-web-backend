<?php
namespace App\Http\Requests\Course;
use Illuminate\Foundation\Http\FormRequest;
class UpdateCourseRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        $id = $this->route('course');
        return [
            'title'             => ['sometimes','required','string','max:255'],
            'slug'              => ['nullable','string','max:255',"unique:courses,slug,{$id}"],
            'description'       => ['sometimes','required','string'],
            'short_description' => ['sometimes','required','string','max:500'],
            'thumbnail'         => ['nullable','string'],
            'price'             => ['sometimes','numeric','min:0'],
            'discount_price'    => ['nullable','numeric','min:0'],
            'level'             => ['sometimes','in:beginner,intermediate,advanced'],
            'category'          => ['sometimes','string'],
            'tags'              => ['nullable','array'],
            'tags.*'            => ['string'],
            'instructor_id'     => ['sometimes','integer','exists:instructors,id'],
            'duration'          => ['nullable','string'],
            'language'          => ['nullable','string'],
            'last_updated'      => ['nullable','date'],
            'is_published'      => ['boolean'],
            'is_featured'       => ['boolean'],
        ];
    }
}
