<?php
namespace App\Http\Requests\Course;
use Illuminate\Foundation\Http\FormRequest;
class StoreCourseRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'title'             => ['required','string','max:255'],
            'slug'              => ['nullable','string','max:255','unique:courses'],
            'description'       => ['required','string'],
            'short_description' => ['required','string','max:500'],
            'thumbnail'         => ['nullable','string'],
            'price'             => ['required','numeric','min:0'],
            'discount_price'    => ['nullable','numeric','min:0'],
            'level'             => ['required','in:beginner,intermediate,advanced'],
            'category'          => ['required','string'],
            'tags'              => ['nullable','array'],
            'tags.*'            => ['string'],
            'instructor_id'     => ['required','integer','exists:instructors,id'],
            'duration'          => ['nullable','string'],
            'language'          => ['nullable','string'],
            'last_updated'      => ['nullable','date'],
            'is_published'      => ['boolean'],
            'is_featured'       => ['boolean'],
        ];
    }
}
