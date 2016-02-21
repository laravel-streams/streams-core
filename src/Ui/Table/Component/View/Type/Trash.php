<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\View\Type;

use Anomaly\Streams\Platform\Ui\Table\Component\View\View;

/**
 * Class Trash
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\View\Type
 */
class Trash extends View
{

    /**
     * The view query.
     *
     * @var string
     */
    protected $query = TrashQuery::class;
}
