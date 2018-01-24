<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Header\Guesser;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Support\Str;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Translation\Translator;

/**
 * Class HeadingsGuesser
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class HeadingsGuesser
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
     * The translator utility.
     *
     * @var Translator
     */
    protected $translator;

    /**
     * Create a new HeadingsGuesser instance.
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

            /*
             * If the heading is already set then
             * we don't have anything to do.
             */
            if (isset($column['heading'])) {
                continue;
            }

            /*
             * If the heading is false, then no
             * header is desired at all.
             */
            if (isset($column['heading']) && $column['heading'] === false) {
                continue;
            }

            /*
             * No stream means we can't
             * really do much here.
             */
            if (!$stream instanceof StreamInterface) {
                continue;
            }

            if (!isset($column['field']) && is_string($column['value'])) {
                $column['field'] = $column['value'];
            }

            /*
             * If the heading matches a field
             * with dot format then reduce it.
             */
            if (isset($column['field']) && preg_match("/^entry.([a-zA-Z\\_]+)/", $column['field'], $match)) {
                $column['field'] = $match[1];
            }

            /*
             * Detect some built in columns.
             */
            if (in_array($column['field'], ['id', 'created_at', 'created_by', 'updated_at', 'updated_by'])) {

                $column['heading']     = 'streams::entry.' . $column['field'];
                $column['sort_column'] = str_replace('_by', '_by_id', $column['field']);

                continue;
            }

            /*
             * Detect entry title.
             */
            if (in_array($column['field'], ['view_link', 'edit_link']) && $field = $stream->getTitleField()) {
                $column['heading'] = $field->getName();

                continue;
            }

            $field = $stream->getField(array_get($column, 'field'));

            /*
             * Detect the title column.
             */
            $title = $stream->getTitleField();

            if (
                $title &&
                !$field &&
                $column['field'] == 'title' &&
                $this->translator->has($heading = $title->getName())
            ) {
                $column['heading'] = $heading;
            }

            /*
             * Use the name from the field.
             */
            if ($field && $heading = $field->getName()) {
                $column['heading'] = $heading;
            }

            /*
             * If no field look for
             * a name anyways.
             */
            if ($module && !$field && $this->translator->has(
                    $heading = $module->getNamespace('field.' . $column['field'] . '.name')
                )
            ) {
                $column['heading'] = $heading;
            }

            /*
             * If no translatable heading yet and
             * the heading matches the value (default)
             * then humanize the heading value.
             */
            if (!isset($column['heading']) && $this->config->get('streams::system.lazy_translations')) {
                $column['heading'] = ucwords($this->string->humanize($column['field']));
            }

            /*
             * If we have a translatable heading and
             * the heading does not have a translation
             * then humanize the heading value.
             */
            if (
                isset($column['heading']) &&
                str_is('*.*.*::*', $column['heading']) &&
                !$this->translator->has($column['heading']) &&
                $this->config->get('streams::system.lazy_translations')
            ) {
                $column['heading'] = ucwords($this->string->humanize($column['field']));
            }

            /*
             * Last resort.
             */
            if ($module && !isset($column['heading'])) {
                $column['heading'] = $module->getNamespace('field.' . $column['field'] . '.name');
            }
        }

        $builder->setColumns($columns);
    }
}
