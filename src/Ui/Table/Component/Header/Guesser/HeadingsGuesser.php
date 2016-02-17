<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Header\Guesser;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class HeadingsGuesser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Button\Guesser
 */
class HeadingsGuesser
{

    /**
     * The module collection.
     *
     * @var ModuleCollection
     */
    protected $modules;

    /**
     * Create a new HeadingsGuesser instance.
     *
     * @param ModuleCollection $modules
     */
    public function __construct(ModuleCollection $modules)
    {
        $this->modules = $modules;
    }

    /**
     * Guess the field for a column.
     *
     * @param TableBuilder $builder
     */
    public function guess(TableBuilder $builder)
    {
        $columns = $builder->getColumns();
        $stream  = $builder->getTableStream();

        $module = $this->modules->active();

        foreach ($columns as &$column) {

            /**
             * If the heading is false or does not exist
             * then the intent was to not have
             * heading text at all.
             */
            if (!isset($column['heading']) || $column['heading'] === false) {
                continue;
            }

            /**
             * No stream means we can't
             * really do much here.
             */
            if (!$stream instanceof StreamInterface) {
                continue;
            }

            /**
             * If the heading matches a field
             * with dot format then reduce it.
             */
            if (preg_match("/^entry.([a-zA-Z\\_]+)/", $column['heading'], $match)) {
                $column['heading'] = $match[1];
            }

            /**
             * Detect some built in columns.
             */
            if (in_array($column['heading'], ['id', 'created_at', 'created_by', 'updated_at', 'updated_by'])) {

                $column['heading'] = trans('streams::entry.' . $column['heading']);

                continue;
            }

            /**
             * Detect entry title.
             */
            if (in_array($column['heading'], ['view_link', 'edit_link']) && $field = $stream->getTitleField()) {

                $column['heading'] = $field->getName();

                continue;
            }

            $field = $stream->getField($column['heading']);

            /**
             * Detect the title column.
             */
            if (!$field && $column['heading'] == 'title' && $title = $stream->getTitleField()) {

                $column['heading'] = trans($title->getName());

                continue;
            }

            /**
             * Use the name from the field.
             */
            if ($field && $name = $field->getName()) {
                $column['heading'] = $name;
            }

            /**
             * If no field look for
             * a name anyways.
             */
            if (!$field && $module && trans()->has(
                    $heading = $module->getNamespace('field.' . $column['heading'] . '.name')
                )
            ) {
                $column['heading'] = $heading;
            }
        }

        $builder->setColumns($columns);
    }
}
