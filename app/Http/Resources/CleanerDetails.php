<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\Category as CategoryResource;
use App\Http\Resources\Brand as BrandResource;
use App\Http\Resources\Warranty as WarrantyResource;
use App\Http\Resources\Photo as PhotoResource;
use App\Http\Resources\Comment as CommentResource;
use App\Http\Resources\Tag as TagResource;

class CleanerDetails extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return array
	 */
	public function toArray($request)
	{
		$info = json_decode($this->description);
		$description = $info->description;
		$properties = $info->properties;

		return [
			'price' => $this->price,
			'description' => $description,
			'properties' => $properties,
			'images' => PhotoResource::collection($this->photos),
			'add_to_basket_url' => route('product.addToBasket', $this->id), // change to product.buy
			'images' => PhotoResource::collection($this->photos),
			'specs' => [
				"full" => [
					'name' => json_decode($this->name)->fa,
					'brand' => new BrandResource($this->brand),
					'warranty' => new WarrantyResource($this->warranty),
					'category' => new CategoryResource($this->category),
					'volume' => $this->volume,
					'healthLicence' => $this->healthLicence,
				]
			],
			'tags' => TagResource::collection($this->tags),
			'discount' => $this->discountPercentage,
			'discountPeriod' => $this->discountPeriod,
			'comment' => CommentResource::collection($this->comment)
		];
	}
}
