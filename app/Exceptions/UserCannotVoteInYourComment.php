<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class UserCannotVoteInYourComment extends Exception
{
    public function render()
    {
        return response()->json([
                'error' => "User cannot vote on his own comment."
            ], Response::HTTP_UNAUTHORIZED );
    }
}
