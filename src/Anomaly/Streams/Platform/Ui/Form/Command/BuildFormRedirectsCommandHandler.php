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

        $entry      = $form->getEntry();
        $presets    = $form->getPresets();
        $expander   = $form->getExpander();
        $evaluator  = $form->getEvaluator();
        $normalizer = $form->getNormalizer();

        $redirects = [];

        foreach ($form->getRedirects() as $slug => $redirect) {

            // Standardize input.
            $redirect = $expander->expand($slug, $redirect);

            // Evaluate everything in the array.
            // All closures are gone now.
            $redirect = $evaluator->evaluate($redirect, compact('form', 'entry'), $entry);

            // Skip if disabled.
            if (array_get($redirect, 'enabled') === false) {

                continue;
            }

            // Get our defaults and merge them in.
            //$defaults = $presets->getDefaults($redirect, $form, $entry);

            //$redirect = array_merge($defaults, $redirect);

            // Build out our required data.
            $name       = $this->getName($form);
            $value      = $this->getUrl($redirect);
            $title      = $this->getTitle($redirect);
            $class      = $this->getClass($redirect);
            $attributes = $this->getAttributes($redirect);

            $redirect = compact('title', 'class', 'value', 'attributes', 'name');

            $redirect = $normalizer->normalize($redirect);

            $redirects[] = $redirect;
        }

        return $redirects;
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
        return trans(array_get($redirect, 'title'));
    }

    /**
     * Get the class.
     *
     * @param array $redirect
     * @return mixed|null
     */
    protected function getClass(array $redirect)
    {
        return array_get($redirect, 'class', 'btn btn-sm btn-success');
    }

    /**
     * Get the URL.
     *
     * @param array $redirect
     * @return string
     */
    protected function getUrl(array $redirect)
    {
        return url(array_get($redirect, 'url'));
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
 