<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Ui\Utility;

class FormUtility extends Utility
{

    protected $redirects = [
        'save'          => [
            'title' => 'button.save',
            'class' => 'btn btn-sm btn-primary',
        ],
        'save_exit'     => [
            'title' => 'button.save_exit',
            'class' => 'btn btn-sm btn-success',
        ],
        'save_create'   => [
            'title' => 'button.save_create',
            'class' => 'btn btn-sm btn-success',
        ],
        'save_continue' => [
            'title' => 'button.save_continue',
            'class' => 'btn btn-sm btn-success',
        ],
    ];

    public function getRedirectDefaults($type)
    {
        if (isset($this->redirects[$type]) and $defaults = $this->redirects[$type]) {

            return $defaults;

        }

        return null;
    }

}
 