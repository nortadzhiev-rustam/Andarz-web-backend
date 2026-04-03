<?php
namespace App\Http\Requests\Quote;
use Illuminate\Foundation\Http\FormRequest;
class StoreQuoteRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return ['content'=>['required','string'],'translation'=>['nullable','string'],'language'=>['nullable','string','size:2'],'author_id'=>['nullable','integer','exists:authors,id'],'category_id'=>['nullable','integer','exists:categories,id'],'is_featured'=>['boolean'],'is_active'=>['boolean']];
    }
}
