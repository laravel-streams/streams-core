<?php namespace Anomaly\Streams\Platform\Ui\Form\Redirect;

class RedirectRepository
{

    protected $redirects = [
        'save' => [
            'slug'   => 'save',
            'button' => [
                'button' => 'success',
                'text'   => 'button.save',
            ],
        ]
    ];

    public function find($redirect)
    {
        $redirect = array_get($this->redirects, $redirect);

        if (is_array($redirect) and !isset($redirect['redirect'])) {

            $redirect['redirect'] = 'Anomaly\Streams\Platform\Ui\Form\Redirect\Redirect';
        }

        return $redirect;
    }
}
 