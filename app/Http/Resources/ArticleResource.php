<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @OA\Schema(
     *     schema="ArticleResource",
     *     type="object",
     *     title="ArticleResource",
     *     @OA\Property(
     *          property="id", 
     *          type="number",
     *          example="1", 
     *          description="Article id"
     *      ),
     *     @OA\Property(
     *          property="name", 
     *          type="string",
     *          example="saife", 
     *          description="Article name"
     *      ),
     *      @OA\Property(
     *          property="email", 
     *          type="string",
     *          example="mattalahsaifeddinne@gmail.com", 
     *          description="Article email"
     *      ),
     * )
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'publishedAt' => $this->publishedAt,
            'category' => $this->category,
            'source' => $this->source,
            'author' => $this->author,
            'title' => $this->title,
            'description' => $this->description,
            'url' => $this->url,
            'urlToImage' => $this->urlToImage
        ];
    }
}
