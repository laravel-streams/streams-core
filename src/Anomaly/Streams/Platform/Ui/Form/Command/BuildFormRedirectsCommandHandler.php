<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\Form;

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
        'url',
        'slug',
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
        $redirects = [];

        $form = $command->getForm();

        $entry      = $form->getEntry();
        $presets    = $form->getPresets();
        $expander   = $form->getExpander();
        $evaluator  = $form->getEvaluator();
        $normalizer = $form->getNormalizer();

        /**
         * Loop through and process redirect configurations.
         */
        foreach ($form->getRedirects() as $slug => $redirect) {

            // Expand and automate.
            $redirect = $expander->expand($slug, $redirect);
            $redirect = $presets->setRedirectPresets($redirect);

            // Evaluate the entire redirect.
            $redirect = $evaluator->evaluate($redirect, compact('form'), $entry);

            // Skip if disabled.
            if (array_get($redirect, 'enabled') === false) {

                continue;
            }

            // Build out our required data.
            $title = array_get($redirect, 'title');
            $class = array_get($redirect, 'class');

            $attributes = $this->getAttributes($redirect, $form);

            $redirects[] = $normalizer->normalize(compact('title', 'class', 'attributes'));
        }

        return $redirects;
    }

    /**
     * Get the attribute string. This is the entire array
     * passed less the keys marked as "not attributes".
     *
     * @param array $redirect
     * @param Form  $form
     * @return array
     */
    protected function getAttributes(array $redirect, Form $form)
    {
        $redirect['value'] = array_get($redirect, 'url');

        $redirect['name'] = $form->getPrefix() . 'redirect';

        return array_diff_key($redirect, array_flip($this->notAttributes));
    }
}
 