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
        $factory = app(HeaderFactory::class);

        HeaderInput::read($builder);

        if ($builder->table->options->get('enable_headers') === false) {
            return;
        }

        foreach ($builder->columns as $header) {

            $header['builder'] = $builder;

            $header = $factory->make($header);

            $builder->table->headers->put($header->field, $header);
        }
    }
}
