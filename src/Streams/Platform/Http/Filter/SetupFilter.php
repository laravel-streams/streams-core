<?php namespace Streams\Platform\Http\Filter;

class SetupFilter
{
    /**
     * Setup the application.
     *
     * @return mixed
     */
    public function filter()
    {
        app('streams.application')->setup();
    }
}
