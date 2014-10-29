<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\FormUi;
use Anomaly\Streams\Platform\Ui\Form\FormUtility;
use Anomaly\Streams\Platform\Entry\EntryInterface;

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
            $redirect = $this->evaluate($redirect, $ui, $entry);

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
     * Evaluate closures in the entire array.
     * Merge in entry data now as well.
     *
     * @param        $redirect
     * @param FormUi $ui
     * @param        $entry
     * @return mixed|null
     */
    protected function evaluate($redirect, FormUi $ui, $entry)
    {
        $redirect = evaluate($redirect, [$ui, $ui->getEntry()]);

        /**
         * In addition to evaluating we need
         * to merge in entry data as best we can.
         */
        foreach ($redirect as &$value) {

            if (is_string($value) and str_contains($value, '{')) {

                if ($entry instanceof EntryInterface) {

                    $value = merge($value, $entry->toArray());

                }

            }

        }

        return $redirect;
    }

    /**
     * Get the defaults for the redirect's type if any.
     *
     * @param $redirect
     * @param $ui
     * @param $entry
     * @return array|mixed|null
     */
    protected function getDefaults($redirect, $ui, $entry)
    {
        $defaults = [];

        if (isset($redirect['type']) and $defaults = $this->utility->getRedirectDefaults($redirect['type'])) {

            $defaults = $this->evaluate($defaults, $ui, $entry);

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

    /**
     * Normalize the resulting data and clean things up
     * before sending it back for the view.
     *
     * @param $redirect
     * @return mixed
     */
    protected function normalize($redirect)
    {
        /**
         * Implode all the attributes left over
         * into an HTML attribute string.
         */
        if (isset($redirect['attributes'])) {

            $redirect['attributes'] = $this->utility->attributes($redirect['attributes']);

        }

        return $redirect;
    }

}
 