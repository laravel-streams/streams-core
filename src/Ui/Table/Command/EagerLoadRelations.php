<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class EagerLoadRelations
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class EagerLoadRelations implements SelfHandling
{

    /**
     * The table builder.
     *
     * @var TableBuilder
     */
    protected $builder;

    /**
     * Create a new EagerLoadRelations instance.
     *
     * @param TableBuilder $builder
     */
    public function __construct(TableBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        $stream = $this->builder->getTableStream();

        if (!$stream instanceof StreamInterface) {
            return;
        }

        $eager = [];

        if ($stream->isTranslatable()) {
            $eager[] = 'translations';
        }

        $assignments = $stream->getRelationshipAssignments();

        foreach ($this->builder->getColumns() as $column) {

            /**
             * If the column value is a string and uses a dot
             * format then check if it's a relation.
             */
            if (is_string($column['value']) && preg_match("/^entry.([a-zA-Z\\_]+)./", $column['value'], $match)) {
                if ($assignment = $assignments->findByFieldSlug($match[1])) {

                    if ($assignment->getFieldType()->getNamespace() == 'anomaly.field_type.polymorphic') {
                        continue;
                    }

                    $eager [] = $match[1];
                }
            }
        }

        $this->builder->setTableOption('eager', array_unique($this->builder->getTableOption('eager', []) + $eager));
    }
}
