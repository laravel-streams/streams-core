<?php namespace Anomaly\Streams\Platform\Ui\Button;

use Anomaly\Streams\Platform\Ui\Button\Contract\ButtonRepositoryInterface;

/**
 * Class ButtonRepository
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Button
 */
class ButtonRepository implements ButtonRepositoryInterface
{

    /**
     * Available button.
     *
     * @var array
     */
    protected $buttons = [
        'cancel' => [
            'text' => 'streams::button.cancel',
            'type' => 'default',
        ],
        'edit'   => [
            'text' => 'streams::button.edit',
            'type' => 'warning',
        ],
        'delete' => [
            'text' => 'streams::button.delete',
            'type' => 'danger',
        ],
    ];

    /**
     * Find a button.
     *
     * @param $button
     * @return mixed
     */
    public function find($button)
    {
        return array_get($this->buttons, $button);
    }
}
