<?php namespace Anomaly\Streams\Platform\Ui\Table\Button\Command;

/**
 * Class StandardizeButtonInputCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Button\Command
 */
class StandardizeButtonInputCommandHandler
{

    /**
     * Handle the command.
     *
     * @param StandardizeButtonInputCommand $command
     */
    public function handle(StandardizeButtonInputCommand $command)
    {
        $builder = $command->getBuilder();

        $buttons = [];

        foreach ($builder->getButtons() as $key => $button) {
            /**
             * If the key is numeric and the button
             * is a string then the button is the button.
             */
            if (is_numeric($key) && is_string($button)) {
                $button = [
                    'button' => $button,
                ];
            }

            /**
             * If the key is NOT numeric and the button is
             * a string then the button becomes the text and
             * the key is the button.
             */
            if (!is_numeric($key) && is_string($button)) {
                $button = [
                    'button' => $key,
                    'text'   => $button,
                ];
            }

            /**
             * If the key is a string and the button is an
             * array without a button then the key is the button.
             */
            if (is_array($button) && !isset($button['button']) && !is_numeric($key)) {
                $button['button'] = $key;
            }

            $buttons[] = $button;
        }

        $builder->setButtons($buttons);
    }
}
