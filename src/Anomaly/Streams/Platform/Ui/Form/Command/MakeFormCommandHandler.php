<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\Event\FormDataLoaded;
use Anomaly\Streams\Platform\Ui\Form\Form;
use Laracasts\Commander\Events\DispatchableTrait;

class MakeFormCommandHandler
{
    use DispatchableTrait;

    public function handle(MakeFormCommand $command)
    {
        $builder = $command->getBuilder();
        $form    = $builder->getForm();

        $this->setSectionData($form);
        $this->setActionData($form);
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
            $sections[] = $section->viewData();
        }

        $form->putData('sections', $sections);
    }

    protected function setActionData(Form $form)
    {
        $actions = [];

        foreach ($form->getActions() as $action) {
            $actions[] = $action->viewData();
        }

        $form->putData('actions', $actions);
    }

    protected function setButtonData(Form $form)
    {
        $buttons = [];

        foreach ($form->getButtons() as $button) {
            $buttons[] = $button->viewData();
        }

        $form->putData('buttons', $buttons);
    }

    protected function setFormData(Form $form)
    {
        $form->putData('prefix', $form->getPrefix());
        $form->putData('locales', $form->getPrefix());

        $translatable = false;

        if ($stream = $form->getStream()) {
            $translatable = $stream->isTranslatable();
        }

        $form->putData('translatable', $translatable);

        $locales = [];

        foreach (config('streams.available_locales') as $k => $locale) {
            $language = trans('language.' . $locale);
            $active   = $locale == config('app.locale');

            $locales[$locale] = compact('locale', 'language', 'active');
        }

        $form->putData('locales', $locales);
    }
}
