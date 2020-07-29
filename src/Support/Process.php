<?php

namespace Anomaly\Streams\Platform\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;

/**
 * Class Process
 *
 * This is a little ditty for processing
 * steps of logic in an extensible way.
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Process
{

    /**
     * The calling subject.
     *
     * @var mixed
     */
    protected $subject = null;

    /**
     * Create a new class instance.
     *
     * @param mixed $subject
     */
    public function __construct($subject = null)
    {
        $this->subject = $subject;
    }
}
