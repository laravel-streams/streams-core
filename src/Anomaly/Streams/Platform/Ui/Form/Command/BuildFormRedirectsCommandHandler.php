<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\FormUi;
use Anomaly\Streams\Platform\Ui\Form\FormUtility;
use Anomaly\Streams\Platform\Entry\EntryInterface;

class BuildFormRedirectsCommandHandler
{

    protected $notAttributes = [
        'title',
        'class',
        'handler',
    ];

    protected $utility;

    function __construct(FormUtility $utility)
    {
        $this->utility = $utility;
    }

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

    protected function getDefaults($redirect, $ui, $entry)
    {
        $defaults = [];

        if (isset($redirect['type']) and $defaults = $this->utility->getRedirectDefaults($redirect['type'])) {

            $defaults = $this->evaluate($defaults, $ui, $entry);

        }

        return $defaults;
    }

    protected function getTitle($redirect)
    {
        return trans(evaluate_key($redirect, 'title'));
    }

    protected function getClass($redirect)
    {
        return evaluate_key($redirect, 'class', 'btn btn-sm btn-success');
    }

    protected function getUrl($redirect)
    {
        return url(evaluate_key($redirect, 'url'));
    }

    protected function getAttributes($redirect)
    {
        return array_diff_key($redirect, array_flip($this->notAttributes));
    }

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
 