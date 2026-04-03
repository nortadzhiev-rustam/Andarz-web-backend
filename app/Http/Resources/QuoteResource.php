<?php
namespace App\Http\Resources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
/** @mixin \App\Models\Quote */
class QuoteResource extends JsonResource {
    public function toArray(Request $request): array {
        return ['id'=>$this->id,'content'=>$this->content,'translation'=>$this->translation,'language'=>$this->language,'is_featured'=>$this->is_featured,'is_active'=>$this->is_active,'author'=>new AuthorResource($this->whenLoaded('author')),'category'=>new CategoryResource($this->whenLoaded('category')),'created_at'=>$this->created_at,'updated_at'=>$this->updated_at];
    }
}
