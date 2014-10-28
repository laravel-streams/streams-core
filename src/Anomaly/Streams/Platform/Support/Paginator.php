<?php namespace Anomaly\Streams\Platform\Support;

use Illuminate\Pagination\LengthAwarePaginator;
use Anomaly\Streams\Platform\Contract\PaginatorInterface;

/**
 * Class Paginator
 *
 * In order to keep naming conventions consistent this class
 * simply overrides the Laravel LengthAwarePaginator and
 * implements our own interface.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Support
 */
class Paginator extends LengthAwarePaginator implements PaginatorInterface
{
}
 