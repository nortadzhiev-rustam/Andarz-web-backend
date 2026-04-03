<?php
namespace App\Http\Requests\Author;
use Illuminate\Foundation\Http\FormRequest;
class StoreAuthorRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return ['name'=>['required','string','max:255','unique:authors'],'slug'=>['nullable','string','max:255','unique:authors'],'bio'=>['nullable','string'],'image_url'=>['nullable','string','url'],'is_active'=>['boolean']];
    }
}
