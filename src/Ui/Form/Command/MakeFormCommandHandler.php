<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\Event\FormDataLoadedEvent;
use Anomaly\Streams\Platform\Ui\Form\Form;

/**
 * Class MakeFormCommandHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form\Command
 */
class MakeFormCommandHandler
{

    /**
     * Handle the command.
     *
     * @param MakeFormCommand $command
     */
    public function handle(MakeFormCommand $command)
    {
        $builder = $command->getBuilder();
        $form    = $builder->getForm();

        $this->setSectionData($form);
        $this->setActionData($form);
        $this->setButtonData($form);
        $this->setFormData($form);

        app('events')->fire('streams::form.data.loaded', new FormDataLoadedEvent($builder));

        $form->setContent(view($form->getView(), $form->getData()));
    }

    /**
     * Set the section data.
     *
     * @param Form $form
     */
    protected function setSectionData(Form $form)
    {
        $sections = [];

        foreach ($form->getSections() as $section) {
            $sections[] = $section->viewData();
        }

        $form->putData('sections', $sections);
    }

    /**
     * Set the action data.
     *
     * @param Form $form
     */
    protected function setActionData(Form $form)
    {
        $actions = [];

        foreach ($form->getActions() as $action) {
            $actions[] = $action->viewData();
        }

        $form->putData('actions', $actions);
    }

    /**
     * Set the button data.
     *
     * @param Form $form
     */
    protected function setButtonData(Form $form)
    {
        $buttons = [];

        foreach ($form->getButtons() as $button) {
            $buttons[] = $button->viewData();
        }

        $form->putData('buttons', $buttons);
    }

    /**
     * Set the form data.
     *
     * @param Form $form
     */
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

        foreach (config('streams::config.available_locales') as $k => $locale) {
            $language = trans('language.' . $locale);
            $active   = $locale == config('app.locale');

            $locales[$locale] = compact('locale', 'language', 'active');
        }

        $form->putData('locales', $locales);
    }
}
