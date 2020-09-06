<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    
    public $collects = ProductResource::class;
    
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'links' => 'metadata'
        ];
    }
}
