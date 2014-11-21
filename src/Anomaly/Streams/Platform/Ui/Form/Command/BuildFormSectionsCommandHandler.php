<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\Contract\FormSectionInterface;
use Anomaly\Streams\Platform\Ui\Form\Form;
use Illuminate\View\View;

/**
 * Class BuildFormSectionsCommandHandler
 *
 * This class basically just resolves the type of
 * section to be used, passes off the data and
 * get's the rendered chunks back.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class BuildFormSectionsCommandHandler
{

    /**
     * These re not attributes and will
     * be omitted from the attributes string.
     *
     * @var array
     */
    protected $notAttributes = [
        'html',
        'slug',
        'type',
        'class',
        'title',
        'layout',
        'handler',
    ];

    /**
     * Handle the command.
     *
     * @param BuildFormSectionsCommand $command
     * @return array
     */
    public function handle(BuildFormSectionsCommand $command)
    {
        $sections = [];

        $form = $command->getForm();

        $entry      = $form->getEntry();
        $presets    = $form->getPresets();
        $expander   = $form->getExpander();
        $evaluator  = $form->getEvaluator();
        $normalizer = $form->getNormalizer();

        /**
         * Loop through and process sections configuration.
         */
        foreach ($form->getSections() as $slug => $section) {

            // Expand, automate, and evaluate.
            $section = $expander->expand($slug, $section, 'type');
            $section = $presets->setSectionPresets($section);
            $section = $evaluator->evaluate($section, compact('form'), $entry);
            $section = $expander->expandLayout($section);

            // Skip if disabled.
            if (array_get($section, 'enabled') === false) {

                continue;
            }

            // Build it out.
            $html       = $this->getHtml($section, $form);
            $attributes = $this->getAttributes($section, $form);

            $sections[] = $normalizer->normalize(compact('class', 'html', 'attributes'));
        }

        return $sections;
    }

    /**
     * Get the HTML.
     *
     * @param array $section
     * @param Form  $form
     * @return null|string
     */
    protected function getHtml(array &$section, Form $form)
    {

        if (isset($section['html']) and is_string($section['html'])) {

            return $section['html'];
        }

        if (isset($section['html']) and $section['html'] instanceof View) {

            return $section['html']->render();
        }

        // Setup the handler.
        $this->setSectionHandler($section, $form);

        /**
         * If the handler is a closure call it
         * through the container.
         */
        if ($section['handler'] instanceof \Closure) {

            return app()->call($section['handler'], compact('form', 'section'));
        }

        /**
         * If the handler is an instance of the interface
         * then authorize and run it's handle method.
         */
        if ($section['handler'] instanceof FormSectionInterface) {

            return $section['handler']->render();
        }

        return null;
    }

    /**
     * Set the handler object..
     *
     * @param array $section
     * @param Form  $form
     * @return mixed
     */
    protected function setSectionHandler(array &$section, Form $form)
    {
        if (is_string($section['handler'])) {

            $section['handler'] = app()->make($section['handler'], compact('form', 'section'));
        }
    }

    /**
     * Get the attributes. This is the entire array
     * less the keys marked as "not attributes".
     *
     * @param array $section
     * @return array
     */
    protected function getAttributes(array $section)
    {
        return array_diff_key($section, array_flip($this->notAttributes));
    }
}
 