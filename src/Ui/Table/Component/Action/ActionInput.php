<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action;

use Anomaly\Streams\Platform\Support\Resolver;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class ActionInput
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Action
 */
class ActionInput
{

    /**
     * The resolver utility.
     *
     * @var Resolver
     */
    protected $resolver;

    /**
     * The action normalizer.
     *
     * @var ActionNormalizer
     */
    protected $normalizer;

    /**
     * Create a new ActionInput instance.
     *
     * @param Resolver         $resolver
     * @param ActionNormalizer $normalizer
     */
    public function __construct(Resolver $resolver, ActionNormalizer $normalizer)
    {
        $this->resolver   = $resolver;
        $this->normalizer = $normalizer;
    }

    /**
     * Read builder action input.
     *
     * @param TableBuilder $builder
     * @return array
     */
    public function read(TableBuilder $builder)
    {
        $this->resolveInput($builder);
        $this->normalizeInput($builder);
    }

    /**
     * Resolve the action input.
     *
     * @param TableBuilder $builder
     */
    protected function resolveInput(TableBuilder $builder)
    {
        $builder->setActions($this->resolver->resolve($builder->getActions()));
    }

    /**
     * Normalize the action input.
     *
     * @param TableBuilder $builder
     */
    protected function normalizeInput(TableBuilder $builder)
    {
        $table   = $builder->getTable();
        $options = $table->getOptions();
        $prefix  = $options->get('prefix');

        $builder->setActions($this->normalizer->normalize($builder->getActions(), $prefix));
    }
}
