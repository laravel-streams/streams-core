<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Button;

use Illuminate\Support\Arr;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Ui\Button\ButtonFactory;
use Anomaly\Streams\Platform\Ui\Button\ButtonCollection;

/**
 * Class ButtonBuilder
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class ButtonBuilder
{

    /**
     * Build the buttons.
     *
     * @param  TableBuilder $builder
     * @param                   $entry
     * @return ButtonCollection
     */
    public static function build(TableBuilder $builder, $entry)
    {
        $table = $builder->getTable();

        $factory = app(ButtonFactory::class);

        $buttons = new ButtonCollection();

        ButtonInput::read($builder);

        foreach ($builder->getButtons() as $button) {

            array_set($button, 'entry', $entry);

            $button = evaluate($button, compact('entry', 'table'));

            $button = Arr::parse($button, compact('entry'));

            $button = self::replace($button, $entry);

            $button = $factory->make(translate($button));

            if ($button->enabled === false) {
                continue;
            }

            $buttons->push($button);
        }

        return $buttons;
    }

    /**
     * Replace input.
     *
     * @param array $button
     * @param mixed $entry
     */
    protected static function replace(array $button, $entry)
    {
        $enabled = array_get($button, 'enabled');

        if (is_string($enabled)) {

            $enabled = filter_var(valuate($enabled, $entry), FILTER_VALIDATE_BOOLEAN);

            $button['enabled'] = $enabled;
        }

        return $button;
    }
}
