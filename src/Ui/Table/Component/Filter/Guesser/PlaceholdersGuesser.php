<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Guesser;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Support\Str;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Translation\Translator;

/**
 * Class PlaceholdersGuesser
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class PlaceholdersGuesser
{

    /**
     * The string utility.
     *
     * @var Str
     */
    protected $string;

    /**
     * The config repository.
     *
     * @var Repository
     */
    protected $config;

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
     * @var Str
     */
    private $str;

    /**
     * Create a new PlaceholdersGuesser instance.
     *
     * @param Str              $string
     * @param Repository       $config
     * @param ModuleCollection $modules
     * @param Translator       $translator
     */
    public function __construct(Str $string, Repository $config, ModuleCollection $modules, Translator $translator)
    {
        $this->string     = $string;
        $this->config     = $config;
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
            if ($stream && $assignment = $stream->getAssignment(array_get($filter, 'field'))) {

                /*
                 * Always use the field name
                 * as the placeholder. Placeholders
                 * that are assigned otherwise usually
                 * feel out of context:
                 *
                 * "Choose an option..." in the filter
                 * would just be weird.
                 */
                $placeholder = $assignment->getFieldName();

                if ($this->translator->has($placeholder)) {
                    $filter['placeholder'] = $placeholder;
                }
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

            if (
                !$this->translator->has($filter['placeholder'])
                && $this->config->get('streams::system.lazy_translations')
            ) {
                $filter['placeholder'] = ucwords($this->string->humanize($filter['placeholder']));
            }
        }

        $builder->setFilters($filters);
    }
}
