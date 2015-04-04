<?php namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Support\Presenter;

/**
 * Class AddonPresenter
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon
 */
class AddonPresenter extends Presenter
{

    /**
     * The resource object.
     * This is for IDE hinting.
     *
     * @var Addon
     */
    protected $object;

    /**
     * Return the translated addon name.
     *
     * @return string
     */
    public function name()
    {
        return trans($this->object->getName());
    }

    /**
     * Return the translated addon description.
     *
     * @return string
     */
    public function description()
    {
        return trans($this->object->getDescription());
    }

    /**
     * Get the entry's view link.
     *
     * @return string
     */
    public function presentViewLink()
    {
        return app('html')->link(
            implode(
                '/',
                array_filter(
                    [
                        'admin',
                        'addons',
                        str_plural($this->object->getType()),
                        $this->object->getNamespace()
                    ]
                )
            ),
            trans($this->object->getName())
        );
    }
}
