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

        $entry   = $form->getEntry();
        $utility = $form->getUtility();

        $sections = [];

        foreach ($form->getSections() as $section) {

            // Standardize input.
            $section = $this->standardize($section);

            // Evaluate the column.
            // All closures are gone now.
            $section = $utility->evaluate($section, [$form, $entry], $entry);

            // Get our defaults and merge them in.
            $defaults = $this->getDefaults($section, $form, $entry);

            $section = array_merge($defaults, $section);

            // Standardize the section layout data being sent.
            // This includes moving fields into blank rows / columns / etc.
            $section = $this->standardizeLayout($section);

            // Get the object responsible for handling the section.
            $handler = $this->getSectionHandler($section, $form);

            if ($handler instanceof FormSectionInterface) {

                // Build out the required data.
                $body    = $handler->body();
                $footer  = $handler->footer();
                $heading = $handler->heading();

                $class = $this->getClass($section);

                $sections[] = compact('class', 'body', 'footer', 'heading');
            }
        }

        return $sections;
    }

    /**
     * Standardize minimum input to the proper data
     * structure we actually expect.
     *
     * @param $section
     */
    protected function standardize($section)
    {
        /**
         * If this is a string it is one
         * of the few default section types.
         */
        if (is_string($section)) {

            $section = [
                'type' => $section,
            ];
        }

        return $section;
    }

    /**
     * Get the default data by the given type.
     *
     * @param array  $section
     * @param Form   $form
     * @param        $entry
     * @return array|mixed|null
     */
    protected function getDefaults(array $section, Form $form, $entry)
    {
        $defaults = [];

        $utility = $form->getUtility();

        if (isset($section['type']) and $defaults = $utility->getSectionDefaults($section['type'])) {

            $defaults = $utility->evaluate($defaults, [$form, $entry], $entry);
        }

        return $defaults;
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

    /**
     * Standardize the layout value.
     *
     * @param array $section
     * @return mixed
     */
    protected function standardizeLayout(array $section)
    {
        if (!isset($section['layout'])) {

            $fields  = evaluate_key($section, 'fields', []);
            $columns = evaluate_key($section, 'columns', [compact('fields')]);
            $rows    = evaluate_key($section, 'rows', [compact('columns')]);
            $layout  = evaluate_key($section, 'layout', compact('rows'));

            $section['layout'] = $layout;

            unset($section['fields'], $section['columns'], $section['rows']);
        }

        return $section;
    }
}
 