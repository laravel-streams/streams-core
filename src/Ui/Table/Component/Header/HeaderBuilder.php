<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Header;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class HeaderBuilder
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Component\Header
 */
class HeaderBuilder
{

    /**
     * The input utility.
     *
     * @var HeaderInput
     */
    protected $input;

    /**
     * The header factory.
     *
     * @var HeaderFactory
     */
    protected $factory;

    /**
     * Create a new HeaderBuilder instance.
     *
     * @param HeaderInput   $input
     * @param HeaderFactory $factory
     */
    public function __construct(HeaderInput $input, HeaderFactory $factory)
    {
        $this->input   = $input;
        $this->factory = $factory;
    }

    /**
     * Build the headers.
     *
     * @param TableBuilder $builder
     */
    public function build(TableBuilder $builder)
    {
        if ($builder->getTableOption('enable_headers') === false) {
            return;
        }

        $table = $builder->getTable();

        $this->input->read($builder);

        foreach ($builder->getColumns() as $column) {

            $column['builder'] = $builder;

            $table->addHeader($this->factory->make($column));
        }
    }
}
