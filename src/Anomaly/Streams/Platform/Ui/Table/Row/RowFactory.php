<?php namespace Anomaly\Streams\Platform\Ui\Table\Row;

/**
 * Class RowFactory
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Row
 */
class RowFactory
{
    /**
     * The default row class.
     *
     * @var string
     */
    protected $row = 'Anomaly\Streams\Platform\Ui\Table\Row\Row';

    /**
     * Make a row.
     *
     * @param array $parameters
     * @return mixed
     */
    public function make(array $parameters)
    {
        return app()->make($this->row, $parameters);
    }
}
