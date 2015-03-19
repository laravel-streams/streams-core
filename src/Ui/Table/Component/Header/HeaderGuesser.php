<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Header;

use Anomaly\Streams\Platform\Ui\Table\Component\Header\Guesser\HeadingGuesser;
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
     * @var HeadingGuesser
     */
    protected $heading;

    /**
     * Create a new HeaderGuesser instance.
     *
     * @param HeadingGuesser $heading
     */
    public function __construct(HeadingGuesser $heading)
    {
        $this->heading = $heading;
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
            $this->heading->guess($header, $builder);
        }

        $builder->setColumns($headers);
    }
}
