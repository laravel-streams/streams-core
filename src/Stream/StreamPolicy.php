<?php

namespace Streams\Core\Stream;

use Streams\Core\Entry\Entry;
use Illuminate\Auth\Access\Gate;
use Illuminate\Contracts\Container\Container;

/**
 * Dispatch model authorization to the policy of the entry's stream.
 */
class StreamPolicy
{
    public function __construct(protected Container $container) {}

    public function before($user = null, string $ability = '', ...$arguments)
    {
        $entry = $arguments[0] ?? null;

        if (! $entry instanceof Entry || ! $entry->stream) {
            return false;
        }

        $policy = $entry->stream()->getPrototypeAttribute('policy');

        if (! is_string($policy) || $policy === '') {
            return false;
        }

        // Use Laravel's policy invocation rules, including guest and before checks.
        $gate = new class($this->container, fn () => $user) extends Gate
        {
            public function evaluate($user, string $ability, array $arguments, string $policy)
            {
                $callback = $this->resolvePolicyCallback(
                    $user, $ability, $arguments, $this->resolvePolicy($policy)
                );

                return $callback ? ($callback() ?? false) : false;
            }
        };

        return $gate->evaluate($user, $ability, $arguments, $policy);
    }

    public function __call(string $method, array $arguments)
    {
        // Laravel checks that the ability is callable before invoking before().
        return false;
    }
}
