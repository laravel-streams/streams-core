<?php namespace Anomaly\Streams\Platform\Assignment\Table\Command;

use Anomaly\Streams\Platform\Assignment\Table\AssignmentTableBuilder;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class SetDefaultProperties
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Assignment\Table\Command
 */
class SetDefaultProperties implements SelfHandling
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
