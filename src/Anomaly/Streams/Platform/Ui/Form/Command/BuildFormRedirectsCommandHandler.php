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
            $name       = $this->getName($redirect, $form);
            $value      = $this->getValue($redirect, $form);
            $title      = $this->getTitle($redirect, $form);
            $class      = $this->getClass($redirect, $form);
            $attributes = $this->getAttributes($redirect, $form);

            $redirect = compact('title', 'class', 'value', 'attributes', 'name');

            $redirect = $normalizer->normalize($redirect);

            $redirects[] = $redirect;
        }

        return $redirects;
    }

    /**
     * Get the name for the redirect button.
     *
     * @param array $redirect
     * @param Form  $form
     * @return string
     */
    protected function getName(array $redirect, Form $form)
    {
        return $form->getPrefix() . 'redirect';
    }

    /**
     * Get the URL.
     *
     * @param array $redirect
     * @param Form  $form
     * @return string
     */
    protected function getValue(array $redirect, Form $form)
    {
        $url = array_get($redirect, 'url');

        if (starts_with($url, 'http')) {

            return url($url);
        }

        return $url;
    }

    /**
     * Get the translated title.
     *
     * @param array $redirect
     * @param Form  $form
     * @return string
     */
    protected function getTitle(array $redirect, Form $form)
    {
        return trans(array_get($redirect, 'title'));
    }

    /**
     * Get the class.
     *
     * @param array $redirect
     * @param Form  $form
     * @return mixed|null
     */
    protected function getClass(array $redirect, Form $form)
    {
        return array_get($redirect, 'class', 'btn btn-sm btn-success');
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
        return array_diff_key($redirect, array_flip($this->notAttributes));
    }
}
 