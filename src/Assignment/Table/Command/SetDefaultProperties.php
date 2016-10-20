<?php namespace Anomaly\Streams\Platform\Assignment\Table\Command;

use Anomaly\Streams\Platform\Assignment\Table\AssignmentTableBuilder;

/**
 * Class SetDefaultProperties
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SetDefaultProperties
{

    /**
     * The table builder.
     *
     * @var AssignmentTableBuilder
     */
    protected $builder;

    /**
     * Create a new SetDefaultProperties instance.
     *
     * @param AssignmentTableBuilder $builder
     */
    public function __construct(AssignmentTableBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        if (!$this->builder->getStream()) {
            $parts = explode('\\', str_replace('AssignmentTableBuilder', 'Model', get_class($this->builder)));

            unset($parts[count($parts) - 2]);

            $model = implode('\\', $parts);

            $this->builder->setStream(app($model)->getStream());
        }
    }
}
