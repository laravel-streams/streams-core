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
     * The form utility object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Form\FormUtility
     */
    protected $utility;

    /**
     * Create a new BuildFormRedirectsCommandHandler instance.
     *
     * @param FormUtility $utility
     */
    function __construct(FormUtility $utility)
    {
        $this->utility = $utility;
    }

    /**
     * Handle the command.
     *
     * @param BuildFormRedirectsCommand $command
     * @return array
     */
    public function handle(BuildFormRedirectsCommand $command)
    {
        $ui = $command->getUi();

        $entry = $ui->getEntry();

        $redirects = [];

        foreach ($ui->getRedirects() as $redirect) {

            // Standardize input.
            $redirect = $this->standardize($redirect);

            // Evaluate everything in the array.
            // All closures are gone now.
            $redirect = $this->utility->evaluate($redirect, [$ui, $entry], $entry);

            // Get our defaults and merge them in.
            $defaults = $this->getDefaults($redirect, $ui, $entry);

            $redirect = array_merge($defaults, $redirect);

            // Build out our required data.
            $name       = $this->getName($ui);
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
     * @param Form $ui
     * @param        $entry
     * @return array|mixed|null
     */
    protected function getDefaults(array $redirect, Form $ui, $entry)
    {
        $defaults = [];

        if (isset($redirect['type']) and $defaults = $this->utility->getRedirectDefaults($redirect['type'])) {

            $defaults = $this->utility->evaluate($defaults, [$ui, $entry], $entry);
        }

        return $defaults;
    }

    /**
     * Get the name for the redirect button.
     *
     * @param Form $ui
     * @return string
     */
    protected function getName(Form $ui)
    {
        return $ui->getPrefix() . 'redirect';
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
 