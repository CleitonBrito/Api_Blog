<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class NotUserComment extends Exception
{
    public function render()
    {
        return response()->json([
            'error' => 'Comment does not belog to the User.'
        ], Response::HTTP_UNAUTHORIZED );
    }
}
