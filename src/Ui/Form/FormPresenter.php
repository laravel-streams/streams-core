<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Support\Presenter;
use Illuminate\View\View;

/**
 * Class FormPresenter
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form
 */
class FormPresenter extends Presenter
{

    /**
     * The decorated object.
     * This is for IDE support.
     *
     * @var Form
     */
    protected $object;

    /**
     * Display the form content.
     *
     * @return string
     */
    function __toString()
    {
        $content = $this->object->getContent();

        if ($content instanceof View) {
            return $content->render();
        }

        return '';
    }
}
