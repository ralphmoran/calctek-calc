<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CalculationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'expression' => $this->expression,
            'result' => $this->result,
            'created_at' => $this->created_at->toISOString(),
        ];
    }
}
