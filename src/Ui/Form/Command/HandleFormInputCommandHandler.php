<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\Form;

/**
 * Class HandleFormInputCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class HandleFormInputCommandHandler
{

    /**
     * Handle the command.
     *
     * @param HandleFormInputCommand $command
     */
    public function handle(HandleFormInputCommand $command)
    {
        $builder = $command->getBuilder();
        $form    = $builder->getForm();

        $this->setIncludeData($form);
        $this->setDefaultData($form);
        $this->setTranslationData($form);
    }

    /**
     * Set the included data.
     *
     * @param Form $form
     */
    protected function setIncludeData(Form $form)
    {
        $input = [];

        foreach ($form->getInclude() as $include) {
            $input[$include] = app('request')->get($form->getPrefix() . $include);
        }

        $form->putInput('include', $input);
    }

    /**
     * Set the default locale data.
     *
     * @param Form $form
     */
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

    /**
     * Set the translated data.
     *
     * @param Form $form
     */
    protected function setTranslationData(Form $form)
    {
        $stream = $form->getStream();

        if (!$stream) {
            return;
        }

        foreach (config('streams::config.available_locales') as $locale) {
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
