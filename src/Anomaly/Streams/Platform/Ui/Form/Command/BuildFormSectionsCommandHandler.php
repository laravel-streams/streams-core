<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\Contract\FormSectionInterface;
use Anomaly\Streams\Platform\Ui\Form\Form;

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
     * Handle the command.
     *
     * @param BuildFormSectionsCommand $command
     * @return array
     */
    public function handle(BuildFormSectionsCommand $command)
    {
        $sections = [];

        $form = $command->getForm();

        $entry     = $form->getEntry();
        $presets   = $form->getPresets();
        $expander  = $form->getExpander();
        $evaluator = $form->getEvaluator();

        /**
         * Loop through and process sections configuration.
         */
        foreach ($form->getSections() as $slug => $section) {

            // Expand, automate, and evaluate.
            $section = $expander->expand($slug, $section);
            $section = $presets->setSectionPresets($section);
            $section = $evaluator->evaluate($section, compact('form'), $entry);

            // Skip if disabled.
            if (array_get($section, 'enabled') === false) {

                continue;
            }

            // Set the handler.
            $this->setSectionHandler($section, $form);

            $section = $this->renderSection($section, $form);

            $sections[] = compact('section');
        }

        return $sections;
    }

    /**
     * @param array $section
     * @param Form  $form
     * @return mixed
     */
    protected function setSectionHandler(array &$section, Form $form)
    {
        if (!isset($section['handler'])) {

            $section['handler'] = 'Anomaly\Streams\Platform\Ui\Form\Section\DefaultFormSection';
        }

        if (is_string($section['handler'])) {

            $section['handler'] = app()->make($section['handler'], compact('form', 'section'));
        }
    }

    /**
     * Render the section.
     *
     * @param array $section
     * @param Form  $form
     * @return null|string
     */
    protected function renderSection(array $section, Form $form)
    {
        /**
         * If the handler is a closure call it
         * through the container.
         */
        if ($section['handler'] instanceof \Closure) {

            return app()->call($section['handler'], compact('form'));
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
}
 