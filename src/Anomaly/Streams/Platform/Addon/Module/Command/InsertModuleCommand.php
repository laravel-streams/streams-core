<?php namespace Anomaly\Streams\Platform\Addon\Module\Command;

class InsertModuleCommand
{

    /**
     * @var
     */
    protected $slug;

    /**
     * @param $slug
     */
    function __construct($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
 