<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\Form;

class HandleFormInputCommandHandler
{

    public function handle(HandleFormInputCommand $command)
    {
        $builder = $command->getBuilder();
        $form    = $builder->getForm();

        $this->setIncludeData($form);
        $this->setDefaultData($form);
        $this->setTranslationData($form);
    }

    protected function setIncludeData(Form $form)
    {
        $input = [];

        foreach ($form->getInclude() as $include) {

            $input[$include] = app('request')->get($form->getPrefix() . $include);
        }

        $form->putInput('include', $input);
    }

    protected function setDefaultData(Form $form)
    {
        $stream = $form->getStream();

        if (!$stream) {

            return;
        }

        $input = [];

        foreach ($stream->getAssignments() as $assignment) {

            $slug = $assignment->getFieldSlug();

            if (in_array($slug, $form->getSkips())) {

                continue;
            }

            $input[$slug] = app('request')->get($form->getPrefix() . $slug . '_' . config('app.locale'));
        }

        $form->putInput(config('app.locale'), $input);
    }

    protected function setTranslationData(Form $form)
    {
        $stream = $form->getStream();

        if (!$stream) {

            return;
        }

        foreach (config('streams.available_locales') as $locale) {

            if ($locale == config('app.locale')) {

                continue;
            }

            $input = [];

            foreach ($stream->getAssignments() as $assignment) {

                $slug = $assignment->getFieldSlug();

                if (!$assignment->isTranslatable()) {

                    continue;
                }

                if (in_array($slug, $form->getSkips())) {

                    continue;
                }

                $input[$slug] = app('request')->get($form->getPrefix() . $slug . '_' . $locale);
            }

            $form->putInput($locale, $input);
        }
    }
}
 