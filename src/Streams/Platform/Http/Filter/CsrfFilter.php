<?php namespace Streams\Platform\Http\Filter;

use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;

class CsrfFilter
{
    /**
     * Run the request filter.
     *
     * @throws \Illuminate\Session\TokenMismatchException
     */
    public function filter(Request $request)
    {
        if (app('session')->token() != $request->input('_token')) {
            throw new TokenMismatchException;
        }
    }
}
