<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\Contract\FormSectionInterface;
use Anomaly\Streams\Platform\Ui\Form\Form;
use Anomaly\Streams\Platform\Ui\Form\FormUtility;

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
     * The form utility object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Form\FormUtility
     */
    protected $utility;

    /**
     * Create a new BuildFormSectionsCommandHandler instance.
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
     * @param BuildFormSectionsCommand $command
     * @return array
     */
    public function handle(BuildFormSectionsCommand $command)
    {
        $ui = $command->getUi();

        $entry = $ui->getEntry();

        $sections = [];

        foreach ($ui->getSections() as $section) {

            // Standardize input.
            $section = $this->standardize($section);

            // Evaluate the column.
            // All closures are gone now.
            $section = $this->utility->evaluate($section, [$ui, $entry], $entry);

            // Get our defaults and merge them in.
            $defaults = $this->getDefaults($section, $ui, $entry);

            $section = array_merge($defaults, $section);

            // Standardize the section layout data being sent.
            // This includes moving fields into blank rows / columns / etc.
            $section = $this->standardizeLayout($section);

            // Get the object responsible for handling the section.
            $handler = $this->getSectionHandler($section, $ui);

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
     * @param Form $ui
     * @param        $entry
     * @return array|mixed|null
     */
    protected function getDefaults(array $section, Form $ui, $entry)
    {
        $defaults = [];

        if (isset($section['type']) and $defaults = $this->utility->getSectionDefaults($section['type'])) {

            $defaults = $this->utility->evaluate($defaults, [$ui, $entry], $entry);
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
     * @param array  $section
     * @param Form $ui
     * @return mixed
     */
    protected function getSectionHandler(array $section, Form $ui)
    {
        $default = 'Anomaly\Streams\Platform\Ui\Form\Section\DefaultFormSection';

        return app()->make(evaluate_key($section, 'handler', $default, [$ui]), compact('section', 'ui'));
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
 