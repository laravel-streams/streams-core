<?php namespace Anomaly\Streams\Platform\Ui\Form\Event;

use Anomaly\Streams\Platform\Ui\Form\FormUtility;

/**
 * Class ConstructingFormUtilityEvent
 *
 * This event is fired during the constructor
 * of the form utility class.
 *
 * This makes it easy for outside APIs to register
 * additional defaults for their add-on features.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Event
 */
class ConstructingFormUtilityEvent
{

    /**
     * The form utility object.
     *
     * @var
     */
    protected $utility;

    /**
     * Create a new ConstructingFormUtilityEvent instance.
     *
     * @param FormUtility $utility
     */
    function __construct(FormUtility $utility)
    {
        $this->utility = $utility;
    }

    /**
     * Get the form utility object.
     *
     * @return mixed
     */
    public function getUtility()
    {
        return $this->utility;
    }

}
 