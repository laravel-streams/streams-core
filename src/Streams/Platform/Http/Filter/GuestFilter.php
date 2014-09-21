<?php namespace Streams\Platform\Http\Filter;

use Auth;
use Redirect;

class GuestFilter
{

    /**
     * Run the request filter.
     *
     * @return mixed
     */
    public function filter()
    {
        if (\Sentry::check()) {
            return Redirect::to('/');
        }
    }

}