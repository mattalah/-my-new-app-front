<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserParamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @OA\Schema(
     *     schema="UserParamResource",
     *     type="object",
     *     title="UserParamResource",
     *     @OA\Property(
     *          property="id", 
     *          type="number",
     *          example="1", 
     *          description="User id"
     *      ),
     *     @OA\Property(
     *          property="publishedAt", 
     *          type="string",
     *          example="2024-01-09T16:32:00Z", 
     *          description="published date"
     *      ),
     *      @OA\Property(
     *          property="source", 
     *          type="string",
     *          example="Google News", 
     *          description="source of article"
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
        ];
    }
}
