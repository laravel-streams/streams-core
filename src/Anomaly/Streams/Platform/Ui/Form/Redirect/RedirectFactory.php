<?php namespace Anomaly\Streams\Platform\Ui\Form\Redirect;

use Anomaly\Streams\Platform\Ui\Button\ButtonFactory;

class RedirectFactory
{

    protected $redirects;

    protected $buttonFactory;

    function __construct(RedirectRepository $redirects, ButtonFactory $buttonFactory)
    {
        $this->redirects       = $redirects;
        $this->buttonFactory = $buttonFactory;
    }

    public function make(array $parameters)
    {
        if (isset($parameters['redirect']) and class_exists($parameters['redirect'])) {

            return $this->makeRedirect($parameters);
        }

        if ($redirect = array_get($parameters, 'redirect') and $redirect = $this->redirects->find($redirect)) {

            return $this->makeRepositoryRedirect($redirect, $parameters);
        }

        return app()->make('Anomaly\Streams\Platform\Ui\Form\Redirect\Redirect', $parameters);
    }

    protected function makeRedirect(array $parameters)
    {
        $this->makeButton($parameters);

        return app()->make($parameters['redirect'], $parameters);
    }

    protected function makeRepositoryRedirect($redirect, $parameters)
    {
        $redirect = array_replace_recursive($redirect, array_except($parameters, 'redirect'));

        $this->makeButton($redirect);

        return app()->make($redirect['redirect'], $redirect);
    }

    protected function makeButton(array &$parameters)
    {
        if (isset($parameters['button'])) {

            if (is_string($parameters['button'])) {

                $parameters['button'] = ['button' => $parameters['button']];
            }

            $parameters['button'] = $this->buttonFactory->make($parameters['button']);

            $parameters['button']->setSize('sm');
        }
    }
}
 