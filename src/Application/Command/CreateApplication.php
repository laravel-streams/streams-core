<?php

namespace Anomaly\Streams\Platform\Application\Command;

use Anomaly\Streams\Platform\Application\ApplicationRepository;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class CreateApplication.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Application\Command
 */
class CreateApplication implements SelfHandling
{
    /**
     * The application attributes.
     *
     * @var array
     */
    protected $attributes;

    /**
     * Create a new CreateApplication instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Handle the command.
     *
     * @param ApplicationRepository $applications
     */
    public function handle(ApplicationRepository $applications)
    {
        return $applications->create($this->attributes);
    }
}
