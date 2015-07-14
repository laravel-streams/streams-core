<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Header;

/**
 * Class Header
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Header
 */
use Anomaly\Streams\Platform\Ui\Table\Component\Header\Contract\HeaderInterface;

/**
 * Class Header
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Header
 */
class Header implements HeaderInterface
{

    /**
     * The header field.
     *
     * @var string
     */
    protected $field;

    /**
     * The header heading.
     *
     * @var string
     */
    protected $heading;

    /**
     * The sortable flag.
     *
     * @var bool
     */
    protected $sortable = false;

    /**
     * Get the header heading.
     *
     * @return mixed
     */
    public function getHeading()
    {
        return $this->heading;
    }

    /**
     * Set the header heading.
     *
     * @param $heading
     * @return $this
     */
    public function setHeading($heading)
    {
        $this->heading = $heading;

        return $this;
    }

    /**
     * Get the sortable flag.
     *
     * @return boolean
     */
    public function isSortable()
    {
        return $this->sortable;
    }

    /**
     * Set the sortable flag.
     *
     * @param boolean $sortable
     * @return $this
     */
    public function setSortable($sortable)
    {
        $this->sortable = $sortable;

        return $this;
    }

    /**
     * Get the field.
     *
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Set the field.
     *
     * @param string $field
     * @return $this
     */
    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }
}
