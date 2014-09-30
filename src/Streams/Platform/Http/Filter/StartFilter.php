<?php namespace Streams\Platform\Http\Filter;

class StartFilter
{
    /**
     * Setup the application.
     *
     * @return mixed
     */
    public function filter()
    {
        app()->make('streams.application')->setup();
    }
}
