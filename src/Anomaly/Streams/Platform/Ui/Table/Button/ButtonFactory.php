<?php namespace Anomaly\Streams\Platform\Ui\Table\Button;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;

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
                $parameters['href'] = function (EntryInterface $entry) use ($path) {

                    return url($path . '/show/' . $entry->getId());
                };
                break;

            /**
             * If using the edit button then suggest
             * the best practice for the "edit" URL.
             */
            case 'edit':
                $parameters['href'] = function (EntryInterface $entry) use ($path) {

                    return url($path . '/edit/' . $entry->getId());
                };
                break;

            /**
             * If using the edit button then suggest
             * the best practice for the "delete" URL.
             */
            case 'delete':
                $parameters['href'] = function (EntryInterface $entry) use ($path) {

                    return url($path . '/delete/' . $entry->getId());
                };
                break;
        }
    }
}
