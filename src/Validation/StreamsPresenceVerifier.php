<?php

namespace Streams\Core\Validation;

use Streams\Core\Support\Facades\Streams;
use Illuminate\Validation\DatabasePresenceVerifier;

class StreamsPresenceVerifier extends DatabasePresenceVerifier
{

    /**
     * Get a query builder for the given table.
     *
     * @param  string  $table
     * @return \Illuminate\Database\Query\Builder
     */
    protected function table($table)
    {
        if (Streams::exists($table)) {
            return Streams::entries($table);
        }

        return parent::table($table);
    }
}
