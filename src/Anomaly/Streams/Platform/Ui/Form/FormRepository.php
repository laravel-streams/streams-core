<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Entry\EntryInterface;
use Anomaly\Streams\Platform\Ui\Form\Contract\FormRepositoryInterface;
use Illuminate\Http\Request;

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
     * @var Form
     */
    protected $form;

    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * @param Form    $form
     * @param Request $request
     */
    function __construct(Form $form, Request $request)
    {
        $this->form    = $form;
        $this->request = $request;
    }

    /**
     * Get the new or exiting entry.
     *
     * @return mixed
     * @throws \Exception
     */
    public function get()
    {
        $id    = $this->form->getEntry();
        $model = $this->form->getModel();

        if (!$id) {

            return $model->newInstance();
        }

        $entry = $model->find($id);

        if ($id and !$entry) {

            throw new \Exception("Entry [{$id}] not found.");
        }

        return $entry;
    }

    /**
     * Store the data to the database.
     */
    public function store()
    {
        $entry = $this->form->getEntry();

        $this->saveDefaultLocale($entry);
        $this->saveTranslations($entry);
    }

    /**
     * Save data for the default locale.
     *
     * @param EntryInterface $entry
     */
    protected function saveDefaultLocale(EntryInterface $entry)
    {
        foreach ($this->form->getData() as $locale => $data) {

            if ($locale == config('app.locale')) {

                foreach ($data as $field => $value) {

                    $entry->{$field} = $value;
                }
            }
        }

        $entry->save();
    }

    /**
     * Save the translated data.
     *
     * @param $entry
     */
    protected function saveTranslations($entry)
    {
        foreach ($this->form->getData() as $locale => $data) {

            if ($locale != config('app.locale') and $locale != 'include') {

                $entry = $entry->translate($locale);

                foreach ($data as $field => $value) {

                    $entry->{$field} = $value;
                }
            }
        }

        $entry->save();
    }
}
 