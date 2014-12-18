<?php namespace Anomaly\Streams\Platform\Ui\Button;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Ui\Button\Contract\ButtonRepositoryInterface;

/**
 * Class ButtonRepository
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Button
 */
class ButtonRepository implements ButtonRepositoryInterface
{

    /**
     * Available button.
     *
     * @var array
     */
    protected $buttons = [
        /**
         * Default type buttons.
         */
        'default' => [
            'type' => 'default',
        ],
        'cancel'  => [
            'text' => 'streams::button.cancel',
            'type' => 'default',
        ],
        /**
         * Primary type buttons.
         */
        'primary' => [
            'type' => 'primary',
        ],
        /**
         * Success type buttons.
         */
        'success' => [
            'type' => 'success',
        ],
        /**
         * Info type buttons.
         */
        'info'    => [
            'type' => 'info',
        ],
        /**
         * Warning type buttons.
         */
        'warning' => [
            'type' => 'warning',
        ],
        'edit'    => [
            'text' => 'streams::button.edit',
            'type' => 'warning',
        ],
        /**
         * Danger type buttons.
         */
        'danger'  => [
            'type' => 'danger',
        ],
        'delete'  => [
            'text' => 'streams::button.delete',
            'type' => 'danger',
        ],
        /**
         * Link type buttons.
         */
        'link'    => [
            'type' => 'link',
        ],
    ];

    /**
     * Find a button.
     *
     * @param  $button
     * @return mixed
     */
    public function find($button)
    {
        $href = $this->guessHref($button);

        $button = array_get($this->buttons, $button);

        if (!isset($button['attributes'])) {
            $button['attributes'] = [];
        }

        if ($href) {
            $button['attributes']['href'] = $href;
        }

        return $button;
    }

    /**
     * Guess the HREF based on the button.
     *
     * @param array $parameters
     */
    protected function guessHref($button)
    {
        $path = app('router')->getCurrentRoute()->getPath();

        switch ($button) {
            /**
             * If using the view button then suggest
             * the best practice for the "view" URL.
             */
            case 'view':
                return function (EntryInterface $entry) use ($path) {
                    return url($path . '/show/' . $entry->getId());
                };
                break;
            /**
             * If using the edit button then suggest
             * the best practice for the "edit" URL.
             */
            case 'edit':
                return function (EntryInterface $entry) use ($path) {
                    return url($path . '/edit/' . $entry->getId());
                };
                break;
            /**
             * If using the edit button then suggest
             * the best practice for the "delete" URL.
             */
            case 'delete':
                return function (EntryInterface $entry) use ($path) {
                    return url($path . '/delete/' . $entry->getId());
                };
                break;

            // No default.
            default:
                return null;
                break;
        }
    }
}
