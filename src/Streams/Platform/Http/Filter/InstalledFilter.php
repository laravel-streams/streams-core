<?php namespace Streams\Platform\Http\Filter;

class InstalledFilter
{
    /**
     * Run the request filter.
     *
     * @return mixed
     */
    public function filter()
    {
        if (!\Application::isInstalled()) {
            return \Redirect::to('installer');
        }
    }
}
