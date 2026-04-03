<?php
namespace App\Http\Requests\Author;
use Illuminate\Foundation\Http\FormRequest;
class UpdateAuthorRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        $id = $this->route('author');
        return ['name'=>['sometimes','required','string','max:255',"unique:authors,name,{$id}"],'slug'=>['nullable','string','max:255',"unique:authors,slug,{$id}"],'bio'=>['nullable','string'],'image_url'=>['nullable','string','url'],'is_active'=>['boolean']];
    }
}
