<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Support\Presenter;
use Collective\Html\FormBuilder as Html;
use Illuminate\View\Factory;
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
     * The form HTML builder.
     *
     * @var Html
     */
    protected $html;

    /**
     * The view factory.
     *
     * @var Factory
     */
    protected $view;

    /**
     * The decorated object.
     * This is for IDE support.
     *
     * @var Form
     */
    protected $object;

    /**
     * Create a new FormPresenter instance.
     *
     * @param Html    $form
     * @param Factory $view
     * @param         $object
     */
    public function __construct(Html $form, Factory $view, $object)
    {
        $this->html = $form;
        $this->view = $view;

        parent::__construct($object);
    }

    /**
     * Return the opening form tag.
     *
     * @param array $options
     * @return string
     */
    public function open(array $options = [])
    {
        return $this->html->open($options);
    }

    /**
     * Return the closing form tag.
     *
     * @return string
     */
    public function close()
    {
        return $this->html->close();
    }

    /**
     * Return the form layout.
     *
     * @param null $view
     * @return string
     */
    public function renderFields($view = null)
    {
        return $this->view
            ->make($view ?: 'streams::form/partials/fields', ['form' => $this->object])
            ->render();
    }

    /**
     * Return the action buttons.
     *
     * @param null $view
     * @return string
     */
    public function renderActions($view = null)
    {
        return $this->view
            ->make($view ?: 'streams::buttons/buttons', ['buttons' => $this->object->getActions()])
            ->render();
    }

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
