<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Button;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class ButtonInput
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Button
 */
class ButtonInput
{

    /**
     * The button lookup.
     *
     * @var ButtonLookup
     */
    protected $lookup;

    /**
     * The button guesser.
     *
     * @var ButtonGuesser
     */
    protected $guesser;

    /**
     * The dropdown utility.
     *
     * @var ButtonDropdown
     */
    protected $dropdown;

    /**
     * The resolver utility.
     *
     * @var ButtonResolver
     */
    protected $resolver;

    /**
     * The button normalizer.
     *
     * @var ButtonNormalizer
     */
    protected $normalizer;

    /**
     * Create a new ButtonInput instance.
     *
     * @param ButtonLookup     $lookup
     * @param ButtonGuesser    $guesser
     * @param ButtonDropdown   $dropdown
     * @param ButtonResolver   $resolver
     * @param ButtonNormalizer $normalizer
     */
    public function __construct(
        ButtonLookup $lookup,
        ButtonGuesser $guesser,
        ButtonDropdown $dropdown,
        ButtonResolver $resolver,
        ButtonNormalizer $normalizer
    ) {
        $this->lookup     = $lookup;
        $this->guesser    = $guesser;
        $this->dropdown   = $dropdown;
        $this->resolver   = $resolver;
        $this->normalizer = $normalizer;
    }

    /**
     * Read builder button input.
     *
     * @param TableBuilder $builder
     */
    public function read(TableBuilder $builder)
    {
        $this->resolver->resolve($builder);
        $this->normalizer->normalize($builder);
        $this->dropdown->flatten($builder);
        $this->lookup->merge($builder);
        $this->normalizer->normalize($builder);
        $this->guesser->guess($builder);
        $this->dropdown->build($builder);
    }
}
