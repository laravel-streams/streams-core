<?php namespace Streams\Platform\Http\Filter;

use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;

class CsrfFilter
{
    /**
     * Run the request filter.
     *
     * @return mixed
     */
    public function filter(Request $request)
    {
        $session = app('session');

        if ($session->token() != $request->input('_token')) {
            throw new TokenMismatchException;
        }
    }
}