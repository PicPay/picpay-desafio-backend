<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;

abstract class JsonRequest extends Request
{
    /**
     * Overrides default Lumen request to get JSON body vars parsed
     * @return array
     */
    public function all( $keys = NULL ): array
    {
        return $this->json()->all( $keys );
    }
}
