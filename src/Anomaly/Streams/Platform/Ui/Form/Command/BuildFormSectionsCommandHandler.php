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
        $form = $command->getForm();

        $entry     = $form->getEntry();
        $expander  = $form->getExpander();
        $evaluator = $form->getEvaluator();

        $sections = [];

        foreach ($form->getSections() as $slug => $section) {

            // Standardize input.
            $section = $expander->expand($slug, $section);

            // Evaluate the column.
            // All closures are gone now.
            $section = $evaluator->evaluate($section, compact('form', 'entry'), $entry);

            // Skip if disabled.
            if (array_get($section, 'enabled') === false) {

                continue;
            }

            // Get our defaults and merge them in.
            //$defaults = $this->getDefaults($section, $form, $entry);

            //$section = array_merge($defaults, $section);

            // Get the object responsible for handling the section.
            $handler = $this->getSectionHandler($section, $form);

            if ($handler instanceof FormSectionInterface) {

                // Build out the required data.
                $html = $handler->render();

                $class = $this->getClass($section);

                $sections[] = compact('html');
            }
        }

        return $sections;
    }

    /**
     * Get the class.
     *
     * @param array $section
     * @return mixed|null
     */
    protected function getClass(array $section)
    {
        return evaluate_key($section, 'class', evaluate_key($section, 'type') . '-section');
    }

    /**
     * @param array $section
     * @param Form  $form
     * @return mixed
     */
    protected function getSectionHandler(array $section, Form $form)
    {
        $default = 'Anomaly\Streams\Platform\Ui\Form\Section\DefaultFormSection';

        return app()->make(evaluate_key($section, 'handler', $default, [$form]), compact('section', 'form'));
    }
}
 