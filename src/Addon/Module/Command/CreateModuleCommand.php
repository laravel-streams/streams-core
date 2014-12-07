<?php namespace Anomaly\Streams\Platform\Addon\Module\Command;

/**
 * Class CreateModuleCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Module\Command
 */
class CreateModuleCommand
{

    /**
     * The slug of the module.
     *
     * @var
     */
    protected $slug;

    /**
     * Create a new CreateModuleCommand instance.
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
 