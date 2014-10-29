<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\FormUi;
use Anomaly\Streams\Platform\Ui\Form\FormUtility;
use Anomaly\Streams\Platform\Entry\EntryInterface;
use Anomaly\Streams\Platform\Ui\Form\Contract\FormSectionInterface;

class BuildFormSectionsCommandHandler
{

    protected $utility;

    function __construct(FormUtility $utility)
    {
        $this->utility = $utility;
    }

    public function handle(BuildFormSectionsCommand $command)
    {
        $ui = $command->getUi();

        $entry = $ui->getEntry();

        $sections = [];

        foreach ($ui->getSections() as $section) {


            // Evaluate the column.
            // All closures are gone now.
            $section = $this->evaluate($section, $ui, $entry);

            // Get our defaults and merge them in.
            $defaults = $this->getDefaults($section, $ui, $entry);

            $section = array_merge($defaults, $section);

            // Get the object responsible for handling the section.
            $handler = $this->getSectionHandler($section, $ui);

            if ($handler instanceof FormSectionInterface) {

                // Build out the required data.
                $body    = $handler->body();
                $footer  = $handler->footer();
                $heading = $handler->heading();

                $slug = $this->getSlug($section);

                $sections[] = compact('slug', 'body', 'footer', 'heading');

            }

        }

        return $sections;
    }

    protected function evaluate($section, FormUi $ui, $entry)
    {
        $section = evaluate($section, [$ui, $ui->getEntry()]);

        /**
         * In addition to evaluating we need
         * to merge in entry data as best we can.
         */
        foreach ($section as &$value) {

            if (is_string($value) and str_contains($value, '{')) {

                if ($entry instanceof EntryInterface) {

                    $value = merge($value, $entry->toArray());

                }

            }

        }

        return $section;
    }

    protected function getDefaults($section, $ui, $entry)
    {
        $defaults = [];

        if (isset($section['type']) and $defaults = $this->utility->getSectionDefaults($section['type'])) {

            $defaults = $this->evaluate($defaults, $ui, $entry);

        }

        return $defaults;
    }

    protected function getSlug($section)
    {
        return evaluate_key($section, 'slug', evaluate_key($section, 'type'));
    }

    protected function getSectionHandler($section, $ui)
    {
        $default = 'Anomaly\Streams\Platform\Ui\Form\Section\DefaultFormSection';

        return app()->make(evaluate_key($section, 'handler', $default, [$ui]), compact('section', 'ui'));
    }

}
 