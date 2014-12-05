<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Button\Contract\ButtonInterface;
use Anomaly\Streams\Platform\Ui\Form\Redirect\Contract\RedirectInterface;
use Anomaly\Streams\Platform\Ui\Form\Event\FormDataLoaded;
use Anomaly\Streams\Platform\Ui\Form\Form;
use Anomaly\Streams\Platform\Ui\Form\Section\Contract\SectionInterface;
use Laracasts\Commander\Events\DispatchableTrait;

class MakeFormCommandHandler
{

    use DispatchableTrait;

    public function handle(MakeFormCommand $command)
    {
        $builder = $command->getBuilder();
        $form    = $builder->getForm();

        $this->setSectionData($form);
        $this->setRedirectData($form);
        $this->setButtonData($form);
        $this->setFormData($form);

        $form->raise(new FormDataLoaded($builder));

        $this->dispatchEventsFor($form);

        $form->setContent(view($form->getView(), $form->getData()));
    }

    protected function setSectionData(Form $form)
    {
        $sections = [];

        foreach ($form->getSections() as $section) {

            if ($section instanceof SectionInterface) {

                $sections[] = $section->viewData();
            }
        }

        $form->putData('sections', $sections);
    }

    protected function setRedirectData(Form $form)
    {
        $redirects = [];

        foreach ($form->getRedirects() as $redirect) {

            if ($redirect instanceof RedirectInterface) {

                $redirects[] = $redirect->viewData();
            }
        }

        $form->putData('redirects', $redirects);
    }

    protected function setButtonData(Form $form)
    {
        $buttons = [];

        foreach ($form->getButtons() as $button) {

            if ($button instanceof ButtonInterface) {

                $buttons[] = $button->viewData();
            }
        }

        $form->putData('buttons', $buttons);
    }

    protected function setFormData(Form $form)
    {
        $form->putData('prefix', $form->getPrefix());

        $translatable = false;

        if ($stream = $form->getStream() and $stream instanceof StreamInterface) {

            $translatable = $stream->isTranslatable();
        }

        $form->putData('translatable', $translatable);
    }
}
 