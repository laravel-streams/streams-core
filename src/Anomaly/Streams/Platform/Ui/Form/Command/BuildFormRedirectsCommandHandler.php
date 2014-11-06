<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\Form;
use Anomaly\Streams\Platform\Ui\Form\FormUtility;

/**
 * Class BuildFormRedirectsCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class BuildFormRedirectsCommandHandler
{

    /**
     * These are not attributes and will
     * not make it into the attribute string.
     *
     * @var array
     */
    protected $notAttributes = [
        'title',
        'class',
    ];

    /**
     * Handle the command.
     *
     * @param BuildFormRedirectsCommand $command
     * @return array
     */
    public function handle(BuildFormRedirectsCommand $command)
    {
        $form = $command->getForm();

        $entry   = $form->getEntry();
        $utility = $form->getUtility();

        $redirects = [];

        foreach ($form->getRedirects() as $redirect) {

            // Standardize input.
            $redirect = $this->standardize($redirect);

            // Evaluate everything in the array.
            // All closures are gone now.
            $redirect = $utility->evaluate($redirect, [$form, $entry], $entry);

            // Get our defaults and merge them in.
            $defaults = $this->getDefaults($redirect, $form, $entry);

            $redirect = array_merge($defaults, $redirect);

            // Build out our required data.
            $name       = $this->getName($form);
            $value      = $this->getUrl($redirect);
            $title      = $this->getTitle($redirect);
            $class      = $this->getClass($redirect);
            $attributes = $this->getAttributes($redirect);

            $redirect = compact('title', 'class', 'value', 'attributes', 'name');

            $redirects[] = $redirect;
        }

        return $redirects;
    }

    /**
     * Standardize minimum input to the proper data
     * structure we actually expect.
     *
     * @param $redirect
     * @return array
     */
    protected function standardize($redirect)
    {
        /**
         * If only the type is sent along
         * we default everything like bad asses.
         */
        if (is_string($redirect)) {

            $redirect = ['type' => $redirect];
        }

        return $redirect;
    }

    /**
     * Get the defaults for the redirect's type if any.
     *
     * @param array  $redirect
     * @param Form   $form
     * @param        $entry
     * @return array|mixed|null
     */
    protected function getDefaults(array $redirect, Form $form, $entry)
    {
        $defaults = [];

        $utility = $form->getUtility();

        if (isset($redirect['type']) and $defaults = $utility->getRedirectDefaults($redirect['type'])) {

            $defaults = $utility->evaluate($defaults, [$form, $entry], $entry);
        }

        return $defaults;
    }

    /**
     * Get the name for the redirect button.
     *
     * @param Form $form
     * @return string
     */
    protected function getName(Form $form)
    {
        return $form->getPrefix() . 'redirect';
    }

    /**
     * Get the translated title.
     *
     * @param array $redirect
     * @return string
     */
    protected function getTitle(array $redirect)
    {
        return trans(evaluate_key($redirect, 'title'));
    }

    /**
     * Get the class.
     *
     * @param array $redirect
     * @return mixed|null
     */
    protected function getClass(array $redirect)
    {
        return evaluate_key($redirect, 'class', 'btn btn-sm btn-success');
    }

    /**
     * Get the URL.
     *
     * @param array $redirect
     * @return string
     */
    protected function getUrl(array $redirect)
    {
        return url(evaluate_key($redirect, 'url'));
    }

    /**
     * Get the attribute string. This is the entire array
     * passed less the keys marked as "not attributes".
     *
     * @param array $redirect
     * @return array
     */
    protected function getAttributes(array $redirect)
    {
        return array_diff_key($redirect, array_flip($this->notAttributes));
    }
}
 