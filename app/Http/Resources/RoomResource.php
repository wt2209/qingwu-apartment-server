<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return [
        //     'id' => $this->id,
        //     'title' => $this->title,
        //     'building' => $this->building,
        //     'unit' => $this->unit,
        //     'rent' => $this->rent,
        //     'remark' => $this->remark,
        //     'category' => new CategoryResource($this->whenLoaded('category')),
        //     'created_at' => $this->created_at,
        //     'updated_at' => $this->updated_at,
        //     'deleted_at' => $this->deleted_at,
        // ];
        return parent::toArray($request);
    }
}
