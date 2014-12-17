<?php namespace Anomaly\Streams\Platform\Ui\Table\Header;

use Anomaly\Streams\Platform\Ui\Table\Header\Contract\HeaderInterface;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class HeaderData
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Header
 */
class HeaderData
{

    /**
     * Make the view data.
     *
     * @param TableBuilder $builder
     */
    public function make(TableBuilder $builder)
    {
        $table = $builder->getTable();
        $data  = $table->getData();

        $headers = array_map(
            function (HeaderInterface $header) {
                return $header->viewData();
            },
            $table->getHeaders()->all()
        );

        $data->put('headers', $headers);
    }
}
