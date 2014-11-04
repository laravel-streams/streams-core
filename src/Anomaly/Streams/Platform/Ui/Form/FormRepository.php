<?php namespace Anomaly\Streams\Platform\Ui\Form;

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

    protected $form;

    protected $request;

    function __construct(Form $form, Request $request)
    {
        $this->form    = $form;
        $this->request = $request;
    }

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

    public function store()
    {
        $entry = $this->form->getEntry();

        $stream = $entry->getStream();

        $this->saveDefaultLocale($stream, $entry);
        $this->saveTranslations($stream, $entry);
    }

    protected function saveDefaultLocale($stream, $entry)
    {
        foreach ($stream->assignments as $assignment) {

            $entry->{$assignment->field->slug} = $this->request->get(
                $this->form->getPrefix() . $assignment->field->slug . '_' . config('app.locale')
            );
        }

        $entry->save();
    }

    protected function saveTranslations($stream, $entry)
    {
        foreach (setting('module.settings::available_locales', ['en', 'fr']) as $locale) {

            if ($stream->isTranslatable() and config('app.locale') != $locale) {

                $entry = $entry->translate($locale);

                foreach ($stream->assignments as $assignment) {

                    if ($assignment->isTranslatable() or config('app.locale') == $locale) {

                        $entry->{$assignment->field->slug} = $this->request->get(
                            $this->form->getPrefix() . $assignment->field->slug . '_' . $locale
                        );
                    }
                }

                $entry->save();
            }
        }
    }
}
 