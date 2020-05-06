<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Header;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class HeaderBuilder
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class HeaderBuilder
{

    /**
     * Build the headers.
     *
     * @param TableBuilder $builder
     */
    public static function build(TableBuilder $builder)
    {
        $table = $builder->getTable();

        $factory = app(HeaderFactory::class);

        HeaderInput::read($builder);

        if ($builder->getTableOption('enable_headers') === false) {
            return;
        }

        foreach ($builder->getColumns() as $header) {

            $header['builder'] = $builder;

            $header = $factory->make($header);

            $table->headers->put($header->field, $header);
        }
    }
}
