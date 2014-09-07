<?php namespace Streams\Core\Ui\Entry;

class EntryResource
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
     * Return the desired entry.
     *
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->ui->getModel()->find($id);
    }

    /**
     * Return a new entry.
     *
     * @return mixed
     */
    public function newEntry()
    {
        return $this->ui->getModel()->newInstance();
    }
}
