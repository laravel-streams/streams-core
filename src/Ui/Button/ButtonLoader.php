<?php namespace Anomaly\Streams\Platform\Ui\Button;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class ButtonLoader
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Button
 */
class ButtonLoader
{

    /**
     * The button reader.
     *
     * @var ButtonReader
     */
    protected $reader;

    /**
     * The button factory.
     *
     * @var ButtonFactory
     */
    protected $factory;

    /**
     * Create a new ButtonLoader instance.
     *
     * @param ButtonReader  $reader
     * @param ButtonFactory $factory
     */
    function __construct(ButtonReader $reader, ButtonFactory $factory)
    {
        $this->reader  = $reader;
        $this->factory = $factory;
    }

    /**
     * Load buttons onto a collection.
     *
     * @param TableBuilder $builder
     */
    public function load(TableBuilder $builder)
    {
        $table   = $builder->getTable();
        $buttons = $table->getButtons();

        foreach ($builder->getButtons() as $key => $parameters) {

            $parameters = $this->reader->standardize($key, $parameters);

            $button = $this->factory->make($parameters);

            $buttons->push($button);
        }
    }
}
