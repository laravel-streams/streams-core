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

            case 'view':
                $parameters['href'] = $path . '/show/{{ entry.id }}';
                break;

            case 'edit':
                $parameters['href'] = $path . '/edit/{{ entry.id }}';
                break;

            case 'delete':
                $parameters['href'] = $path . '/delete/{{ entry.id }}';
                break;
        }
    }
}
 