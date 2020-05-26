<?php

namespace Anomaly\Streams\Platform\Ui\Tree\Component\Button;

use Illuminate\Support\Str;
use Anomaly\Streams\Platform\Ui\Tree\TreeBuilder;
use Anomaly\Streams\Platform\Ui\Button\ButtonFactory;
use Anomaly\Streams\Platform\Support\Facades\Evaluator;
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
     * @param  TreeBuilder      $builder
     * @param                   $entry
     * @return ButtonCollection
     */
    public static function build(TreeBuilder $builder, $entry)
    {
        $tree = $builder->tree;

        $factory = app(ButtonFactory::class);

        $buttons = new ButtonCollection();

        ButtonInput::read($builder, $entry);

        foreach ($builder->buttons as $button) {
            
            if (!array_get($button, 'enabled', true)) {
                continue;
            }

            $button = Evaluator::evaluate($button, compact('entry', 'tree'));
            $button = Str::parse($button, $entry);

            $button = $factory->make($button);
dd($button);
            $buttons->push($button);
        }

        return $buttons;
    }
}
