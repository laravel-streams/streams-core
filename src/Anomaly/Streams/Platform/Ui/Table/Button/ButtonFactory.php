<?php namespace Anomaly\Streams\Platform\Ui\Table\Button;

class ButtonFactory extends \Anomaly\Streams\Platform\Ui\Button\ButtonFactory
{
    protected $button = 'Anomaly\Streams\Platform\Ui\Table\Button\Button';

    public function make(array $parameters)
    {
        if (!isset($parameters['href'])) {
            $this->guessHref($parameters);
        }

        return parent::make($parameters);
    }

    protected function guessHref(array &$parameters)
    {
        $path = app('router')->getCurrentRoute()->getPath();

        switch (array_get($parameters, 'button')) {

            /**
             * If using the view button then suggest
             * the best practice for the "view" URL.
             */
            case 'view':
                $parameters['href'] = url($path . '/show/{{ entry.id }}');
                break;

            /**
             * If using the edit button then suggest
             * the best practice for the "edit" URL.
             */
            case 'edit':
                $parameters['href'] = url($path . '/edit/{{ entry.id }}');
                break;

            /**
             * If using the edit button then suggest
             * the best practice for the "delete" URL.
             */
            case 'delete':
                $parameters['href'] = url($path . '/delete/{{ entry.id }}');
                break;
        }
    }
}
