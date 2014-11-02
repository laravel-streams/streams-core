<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Ui\Form\Contract\FormRepositoryInterface;

/**
 * Class FormRepository
 *
 * This class is responsible for handling the retrieval
 * and storage of entry data from the form.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form
 */
class FormRepository implements FormRepositoryInterface
{

    /**
     * The form UI object.
     *
     * @var FormUi
     */
    protected $ui;

    /**
     * The model if any.
     *
     * @var null
     */
    protected $model;

    /**
     * @param FormUi $ui
     * @param null   $model
     */
    function __construct(FormUi $ui, $model = null)
    {
        $this->ui    = $ui;
        $this->model = $model;
    }

    /**
     * Get the entry for the form.
     *
     * @return mixed
     * @throws \Exception
     */
    public function get()
    {
        $id = $this->ui->getEntry();

        if (!$id) {

            return $this->model->newInstance();
        }

        $entry = $this->model->find($id);

        if ($id and !$entry) {

            throw new \Exception("Entry [{$id}] not found.");
        }

        return $entry;
    }

    /**
     * Store the form changes.
     *
     * @return bool
     */
    public function store()
    {
        return true;
    }
}
 