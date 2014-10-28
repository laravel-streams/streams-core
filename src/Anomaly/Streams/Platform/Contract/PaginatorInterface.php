<?php namespace Anomaly\Streams\Platform\Contract;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Interface PaginatorInterface
 *
 * In order to keep naming conventions consistent this interface
 * simply extends the Laravel contract for now.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Contract
 */
interface PaginatorInterface extends LengthAwarePaginator
{
}
 