<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Support\Presenter;
use Illuminate\View\View;

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
        if ($url = $this->object->getOption('url')) {
            $options['url'] = $url;
        } else {
            $options['url'] = request()->fullUrl();
        }

        if ($this->object->hasFileInput()) {
            $options['enctype'] = 'multipart/form-data';
        }

        return app('form')->open($options);
    }

    /**
     * Return the closing form tag.
     *
     * @return string
     */
    public function close()
    {
        return app('form')->close();
    }

    /**
     * Return the form layout.
     *
     * @param  null $view
     * @return string
     */
    public function renderFields($view = null)
    {
        return view(
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
        return view($view ?: 'streams::buttons/buttons', ['buttons' => $this->object->getActions()])->render();
    }

    /**
     * Display the form content.
     *
     * @return string
     */
    public function __toString()
    {
        $content = $this->object->getContent();

        if ($content instanceof View) {
            return $content->render();
        }

        return '';
    }
}
