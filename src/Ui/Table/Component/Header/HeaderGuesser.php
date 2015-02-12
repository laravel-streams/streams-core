<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Header;

use Anomaly\Streams\Platform\Ui\Table\Component\Header\Guesser\FieldGuesser;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class HeaderGuesser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Header
 */
class HeaderGuesser
{

    /**
     * The field guesser.
     *
     * @var FieldGuesser
     */
    protected $field;

    /**
     * Create a new HeaderGuesser instance.
     *
     * @param FieldGuesser $field
     */
    public function __construct(FieldGuesser $field)
    {
        $this->field = $field;
    }

    /**
     * Guess header properties.
     *
     * @param TableBuilder $builder
     */
    public function guess(TableBuilder $builder)
    {
        $headers = $builder->getColumns();

        foreach ($headers as &$header) {
            $this->field->guess($header);
        }

        $builder->setColumns($headers);
    }
}
