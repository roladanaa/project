<?php

namespace App\Http\Resources;

use App\Models\SubCategory;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
            'name' => $this->name,
            'image' => Storage::url($this->image),
            'sub_categories' => $this->subCat($this->subCategory)
        ];
    }

    public function subCat($subCategories){

        $arrData = [];
        foreach($subCategories as $sub){
            if($sub->status == 'active'){
                array_push($arrData,[
                    'id'=>$sub->id,
                    'name'=>$sub->name,
                    'image'=>Storage::url($sub->image),
                ]);
            }
        }
        return $arrData;
    }
}
