<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Header;

use Anomaly\Streams\Platform\Ui\Table\Component\Header\Guesser\FieldGuesser;

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
     * @param array $headers
     * @return array
     */
    public function guess(array $headers)
    {
        foreach ($headers as &$header) {
            $this->field->guess($header);
        }

        return $headers;
    }
}
