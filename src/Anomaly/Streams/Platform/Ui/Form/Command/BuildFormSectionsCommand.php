<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\FormUi;

class BuildFormSectionsCommand
{
    protected $ui;

    function __construct(FormUi $ui)
    {
        $this->ui = $ui;
    }

    /**
     * @param mixed $ui
     */
    public function setUi($ui)
    {
        $this->ui = $ui;
    }

    /**
     * @return mixed
     */
    public function getUi()
    {
        return $this->ui;
    }
}
 