<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Form\Form;

/**
 * Class BuildFormOptionsCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class BuildFormOptionsCommandHandler
{

    /**
     * Handle the command.
     *
     * @param BuildFormOptionsCommand $command
     * @return array
     */
    public function handle(BuildFormOptionsCommand $command)
    {
        $form = $command->getForm();

        $locales      = $this->getLocales($form);
        $translatable = $this->getTranslatable($form);

        return compact('translatable', 'locales');
    }

    /**
     * Get available locales.
     *
     * @param Form $form
     * @return array
     */
    protected function getLocales(Form $form)
    {
        $locales = [];

        foreach (config('streams.available_locales') as $locale) {

            $language = trans('language.' . $locale);

            $locales[$locale] = compact('locale', 'language');
        }

        return $locales;
    }

    /**
     * Get the translatable flag.
     *
     * @param Form $form
     * @return bool
     */
    protected function getTranslatable(Form $form)
    {
        $stream = $form->getStream();

        if ($stream instanceof StreamInterface) {

            return $stream->isTranslatable();
        }

        return false;
    }
}
 