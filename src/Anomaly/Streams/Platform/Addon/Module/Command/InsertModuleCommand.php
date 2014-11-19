<?php namespace Anomaly\Streams\Platform\Addon\Module\Command;

/**
 * Class InsertModuleCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Module\Command
 */
class InsertModuleCommand
{

    /**
     * The slug of the module.
     *
     * @var
     */
    protected $slug;

    /**
     * Create a new InsertModuleCommand instance.
     *
     * @param $slug
     */
    function __construct($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Get the module slug.
     *
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
 