<?php
namespace App\Http\Resources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
/** @mixin \App\Models\Author */
class AuthorResource extends JsonResource {
    public function toArray(Request $request): array {
        return ['id'=>$this->id,'name'=>$this->name,'slug'=>$this->slug,'bio'=>$this->bio,'image_url'=>$this->image_url,'is_active'=>$this->is_active,'created_at'=>$this->created_at,'updated_at'=>$this->updated_at];
    }
}
