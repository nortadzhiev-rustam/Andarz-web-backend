<?php
namespace App\Http\Requests\Instructor;
use Illuminate\Foundation\Http\FormRequest;
class UpdateInstructorRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return ['name'=>['sometimes','required','string','max:255'],'avatar'=>['nullable','string'],'bio'=>['nullable','string']];
    }
}
