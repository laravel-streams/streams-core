<?php namespace Anomaly\Streams\Platform\Ui\Form\Section\Command;

/**
 * Class StandardizeSectionInputCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Section\Command
 */
class StandardizeSectionInputCommandHandler
{
    /**
     * Handle the command.
     *
     * @param StandardizeSectionInputCommand $command
     */
    public function handle(StandardizeSectionInputCommand $command)
    {
        $builder = $command->getBuilder();

        $sections = [];

        foreach ($builder->getSections() as $key => $section) {
            if (isset($section['fields'])) {
                $section['section'] = 'fields';
            }

            $sections[] = $section;
        }

        $builder->setSections($sections);
    }
}
