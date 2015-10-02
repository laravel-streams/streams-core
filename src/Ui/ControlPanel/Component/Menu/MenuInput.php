<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Menu;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class MenuInput
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\ControlPanel\Component\Menu
 */
class MenuInput
{

    /**
     * The menu parser.
     *
     * @var MenuParser
     */
    protected $parser;

    /**
     * The module collection.
     *
     * @var ModuleCollection
     */
    protected $modules;

    /**
     * The menu guesser.
     *
     * @var MenuGuesser
     */
    protected $guesser;

    /**
     * The menu evaluator.
     *
     * @var MenuEvaluator
     */
    protected $evaluator;

    /**
     * The resolver utility.
     *
     * @var MenuResolver
     */
    protected $resolver;

    /**
     * The menu normalizer.
     *
     * @var MenuNormalizer
     */
    protected $normalizer;

    /**
     * Create a new MenuInput instance.
     *
     * @param MenuParser       $parser
     * @param MenuGuesser      $guesser
     * @param ModuleCollection $modules
     * @param MenuResolver     $resolver
     * @param MenuEvaluator    $evaluator
     * @param MenuNormalizer   $normalizer
     */
    function __construct(
        MenuParser $parser,
        MenuGuesser $guesser,
        ModuleCollection $modules,
        MenuResolver $resolver,
        MenuEvaluator $evaluator,
        MenuNormalizer $normalizer
    ) {
        $this->parser     = $parser;
        $this->guesser    = $guesser;
        $this->modules    = $modules;
        $this->resolver   = $resolver;
        $this->evaluator  = $evaluator;
        $this->normalizer = $normalizer;
    }

    /**
     * Read the menu input and process it
     * before building the objects.
     *
     * @param ControlPanelBuilder $builder
     */
    public function read(ControlPanelBuilder $builder)
    {
        $this->resolver->resolve($builder);
        $this->normalizer->normalize($builder);
        $this->guesser->guess($builder);
        $this->evaluator->evaluate($builder);
        $this->parser->parse($builder);
    }
}
