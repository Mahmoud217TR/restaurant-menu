<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'discount' => $this->calculated_discount,
            'items' => $this->when($this->containsItems(), function(){
                return ItemResource::collection($this->items()->orderBy('title')->get());
            }),
            'level' => $this->getSubCategoryLevel(),
            'sub_categories' => $this->when($this->containsSubCategories(), function(){
                return CategoryResource::collection($this->subCategories);
            }),
        ];
    }
}
