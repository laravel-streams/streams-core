<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\View\Type;

use Anomaly\Streams\Platform\Ui\Table\Component\View\View;

/**
 * Class ViewAll
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\View\Type
 */
class ViewAll extends View
{

    /**
     * The view query.
     *
     * @var string
     */
    protected $query = 'Anomaly\Streams\Platform\Ui\Table\Component\View\Type\ViewAllQuery@handle';

}
