<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\Contract\FormSectionInterface;
use Anomaly\Streams\Platform\Ui\Form\FormUi;
use Anomaly\Streams\Platform\Entry\EntryInterface;

class BuildFormSectionsCommandHandler
{

    public function handle(BuildFormSectionsCommand $command)
    {
        $ui = $command->getUi();

        $entry = $ui->getEntry();

        $sections = [];

        foreach ($ui->getSections() as $section) {

            // Evaluate the column.
            // All closures are gone now.
            $section = $this->evaluate($section, $ui, $entry);

            $section = $this->getSectionObject($section, $ui);

            if ($section instanceof FormSectionInterface) {

                $body = $section->body();

                $sections[] = compact('body');

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

    protected function getSectionObject($section, $ui)
    {
        $default = 'Anomaly\Streams\Platform\Ui\Form\Section\DefaultFormSection';

        return app()->make(evaluate_key($section, 'type', $default, [$ui]), compact('section', 'ui'));
    }

}
 