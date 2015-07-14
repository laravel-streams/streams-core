<?php namespace Anomaly\Streams\Platform\Asset\Event;

use Anomaly\Streams\Platform\Support\Collection;

/**
 * Class ThemeVariablesAreLoading
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Asset\Event
 */
class ThemeVariablesAreLoading
{

    /**
     * The theme variables.
     *
     * @var Collection
     */
    protected $variables;

    /**
     * Create a new ThemeVariablesAreLoading instance.
     *
     * @param Collection $variables
     */
    function __construct(Collection $variables)
    {
        $this->variables = $variables;
    }

    /**
     * Get the variables.
     *
     * @return Collection
     */
    public function getVariables()
    {
        return $this->variables;
    }
}
