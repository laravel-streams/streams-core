<?php namespace Anomaly\Streams\Platform\Ui\Button;

use Anomaly\Streams\Platform\Ui\Button\Contract\ButtonRepositoryInterface;

class ButtonRepository implements ButtonRepositoryInterface
{

    protected $buttons = [
        'edit' => [
            'class' => 'btn btn-warning',
        ]
    ];

    public function find($button)
    {
        $button = array_get($this->buttons, $button);

        if (!isset($button['button'])) {

            $button['button'] = 'Anomaly\Streams\Platform\Ui\Button\Button';
        }

        return $button;
    }
}
 