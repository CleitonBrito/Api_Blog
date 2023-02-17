<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class UserIsOwnerFromComment extends Exception
{
    public function render()
    {
        return response()->json([
            'error' => "User cannot comment on his own comment."
        ], Response::HTTP_UNAUTHORIZED );
    }
}
