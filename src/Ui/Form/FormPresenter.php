<?php

namespace Anomaly\Streams\Platform\Ui\Form;

use Collective\Html\FormFacade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Request;
use Collective\Html\FormBuilder as Html;
use Anomaly\Streams\Platform\Support\Presenter;

/**
 * Class FormPresenter
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
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
     * Return the opening form tag.
     *
     * @param  array $options
     * @return string
     */
    public function open(array $options = [])
    {
        if ($url = $this->object->options->get('url')) {
            $options['url'] = $url;
        } else {
            $options['url'] = Request::fullUrl();
        }

        // For good measure?
        // @todo is this a security risk?
        $options['enctype'] = 'multipart/form-data';

        if ($this->object->options->get('ajax') === true) {
            $options['data-async'] = 'true';
        }

        return FormFacade::open($options);
    }

    /**
     * Return the closing form tag.
     *
     * @return string
     */
    public function close()
    {
        return FormFacade::close();
    }

    /**
     * Return the form layout.
     *
     * @param  null $view
     * @return string
     */
    public function renderFields($view = null)
    {
        return View::make(
                $view ?: 'streams::form/partials/fields',
                [
                    'form'   => $this,
                    'fields' => array_unique($this->object->getFields()->fieldNames()),
                ]
            )
            ->render();
    }

    /**
     * Return the action buttons.
     *
     * @param  null $view
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
    public function __toString()
    {
        return $this->object
            ->render()
            ->render();
    }
}
