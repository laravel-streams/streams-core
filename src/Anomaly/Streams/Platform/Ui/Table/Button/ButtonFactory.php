<?php namespace Anomaly\Streams\Platform\Ui\Table\Button;

/**
 * Class ButtonFactory
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Button
 */
class ButtonFactory extends \Anomaly\Streams\Platform\Ui\Button\ButtonFactory
{
    /**
     * The default button class.
     *
     * @var string
     */
    protected $button = 'Anomaly\Streams\Platform\Ui\Table\Button\Button';

    /**
     * Make a button.
     *
     * @param array $parameters
     * @return mixed
     */
    public function make(array $parameters)
    {
        if (!isset($parameters['href'])) {
            $this->guessHref($parameters);
        }

        return parent::make($parameters);
    }

    /**
     * Guess the HREF based on the button.
     *
     * @param array $parameters
     */
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
