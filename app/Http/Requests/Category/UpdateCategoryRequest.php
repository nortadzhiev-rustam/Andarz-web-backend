<?php
namespace App\Http\Requests\Category;
use Illuminate\Foundation\Http\FormRequest;
class UpdateCategoryRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        $id = $this->route('category');
        return ['name'=>['sometimes','required','string','max:255',"unique:categories,name,{$id}"],'slug'=>['nullable','string','max:255',"unique:categories,slug,{$id}"],'description'=>['nullable','string'],'is_active'=>['boolean']];
    }
}
