<?php namespace Streams\Core\Ui\Entry;

class EntryRepository
{
    /**
     * The UI object.
     *
     * @var
     */
    protected $ui;

    /**
     * Create a new EntryRepository instance.
     *
     * @param $ui
     */
    public function __construct($ui)
    {
        $this->ui = $ui;
    }

    /**
     * Return the desired entries.
     *
     * @return mixed
     */
    public function get()
    {
        return $this->ui->getModel()->get();
    }
}
