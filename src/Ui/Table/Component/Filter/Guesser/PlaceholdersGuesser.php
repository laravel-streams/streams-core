<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Guesser;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Translation\Translator;

/**
 * Class PlaceholdersGuesser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Filter\Guesser
 */
class PlaceholdersGuesser
{

    /**
     * The module collection.
     *
     * @var ModuleCollection
     */
    protected $modules;

    /**
     * The translator service.
     *
     * @var Translator
     */
    protected $translator;

    /**
     * Create a new PlaceholdersGuesser instance.
     *
     * @param ModuleCollection $modules
     * @param Translator       $translator
     */
    public function __construct(ModuleCollection $modules, Translator $translator)
    {
        $this->modules    = $modules;
        $this->translator = $translator;
    }

    /**
     * Guess some table table filter placeholders.
     *
     * @param TableBuilder $builder
     */
    public function guess(TableBuilder $builder)
    {
        $filters = $builder->getFilters();
        $stream  = $builder->getTableStream();

        foreach ($filters as &$filter) {

            // Skip if we already have a placeholder.
            if (isset($filter['placeholder'])) {
                continue;
            }

            // Get the placeholder off the assignment.
            if ($assignment = $stream->getAssignment(array_get($filter, 'field'))) {

                /**
                 * Always use the field name
                 * as the placeholder. Placeholders
                 * that are assigned otherwise usually
                 * feel out of context:
                 *
                 * "Choose an option..." in the filter
                 * would just be weird.
                 */
                $filter['placeholder'] = $assignment->getFieldName();
            }

            if (!$module = $this->modules->active()) {
                continue;
            }

            $placeholder = $module->getNamespace('field.' . $filter['slug'] . '.placeholder');

            if (!isset($filter['placeholder']) && $this->translator->has($placeholder)) {
                $filter['placeholder'] = $placeholder;
            }

            $placeholder = $module->getNamespace('field.' . $filter['slug'] . '.name');

            if (!isset($filter['placeholder']) && $this->translator->has($placeholder)) {
                $filter['placeholder'] = $placeholder;
            }

            if (!array_get($filter, 'placeholder')) {
                $filter['placeholder'] = $filter['slug'];
            }
        }

        $builder->setFilters($filters);
    }
}
