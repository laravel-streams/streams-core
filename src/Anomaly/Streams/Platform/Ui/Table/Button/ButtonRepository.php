<?php namespace Anomaly\Streams\Platform\Ui\Table\Button;

use Anomaly\Streams\Platform\Ui\Table\Button\Contract\ButtonRepositoryInterface;

class ButtonRepository implements ButtonRepositoryInterface
{

    protected $buttons = [
        'success' => [
            'class' => 'btn btn-success',
        ],
        'info'    => [
            'class' => 'btn btn-info',
        ],
        'warning' => [
            'class' => 'btn btn-warning',
        ],
        'danger'  => [
            'class' => 'btn btn-danger',
        ],
        'edit'    => [
            'text'  => 'button.edit',
            'class' => 'btn btn-warning',
        ]
    ];

    public function find($button)
    {
        $button = array_get($this->buttons, $button);

        if (!isset($button['button'])) {

            $button['button'] = 'Anomaly\Streams\Platform\Ui\Table\Button\Button';
        }

        return $button;
    }
}
 