<?php namespace Anomaly\Streams\Platform\Ui\Form\Multiple\Command;

use Anomaly\Streams\Platform\Ui\Form\Multiple\MultipleFormBuilder;

/**
 * Class HandleLocks
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class HandleLocks
{

    /**
     * The multiple form builder.
     *
     * @var MultipleFormBuilder
     */
    protected $builder;

    /**
     * Create a new HandleLocks instance.
     *
     * @param MultipleFormBuilder $builder
     */
    public function __construct(MultipleFormBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     *
     */
    public function handle()
    {
        $forms = $this->builder->getForms();

        $locked = $forms->locked();

        if ($locked->isEmpty()) {
            return;
        }

        $this->builder->setLocked(true);
        $this->builder->setSave(false);
    }
}
