<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\FormUi;
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

            /**
             * If only the type is sent along
             * we default everything like bad asses.
             */
            if (is_string($redirect)) {

                $redirect = ['type' => $redirect];

            }

            // Evaluate everything in the array.
            // All closures are gone now.
            $redirect = $this->utility->evaluate($redirect, [$ui, $entry], $entry);

            // Get our defaults and merge them in.
            $defaults = $this->getDefaults($redirect, $ui, $entry);

            $redirect = array_merge($defaults, $redirect);

            // Build out our required data.
            $value      = $this->getUrl($redirect);
            $title      = $this->getTitle($redirect);
            $class      = $this->getClass($redirect);
            $attributes = $this->getAttributes($redirect);

            $redirect = compact('title', 'class', 'value', 'attributes');

            $redirects[] = $redirect;

        }

        return $redirects;
    }

    /**
     * Get the defaults for the redirect's type if any.
     *
     * @param        $redirect
     * @param FormUi $ui
     * @param        $entry
     * @return array|mixed|null
     */
    protected function getDefaults($redirect, FormUi $ui, $entry)
    {
        $defaults = [];

        if (isset($redirect['type']) and $defaults = $this->utility->getRedirectDefaults($redirect['type'])) {

            $defaults = $this->utility->evaluate($defaults, [$ui, $entry], $entry);

        }

        return $defaults;
    }

    /**
     * Get the translated title.
     *
     * @param $redirect
     * @return string
     */
    protected function getTitle($redirect)
    {
        return trans(evaluate_key($redirect, 'title'));
    }

    /**
     * Get the class.
     *
     * @param $redirect
     * @return mixed|null
     */
    protected function getClass($redirect)
    {
        return evaluate_key($redirect, 'class', 'btn btn-sm btn-success');
    }

    /**
     * Get the URL.
     *
     * @param $redirect
     * @return string
     */
    protected function getUrl($redirect)
    {
        return url(evaluate_key($redirect, 'url'));
    }

    /**
     * Get the attribute string. This is the entire array
     * passed less the keys marked as "not attributes".
     *
     * @param $redirect
     * @return array
     */
    protected function getAttributes($redirect)
    {
        return array_diff_key($redirect, array_flip($this->notAttributes));
    }

}
 