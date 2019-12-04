<?php

namespace Anomaly\Streams\Platform\Ui\Tree\Component\Button;

use Anomaly\Streams\Platform\Support\Evaluator;
use Anomaly\Streams\Platform\Ui\Button\ButtonCollection;
use Anomaly\Streams\Platform\Ui\Button\ButtonFactory;
use Anomaly\Streams\Platform\Ui\Tree\TreeBuilder;

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
        $tree = $builder->getTree();

        $factory = app(ButtonFactory::class);

        $buttons = new ButtonCollection();

        ButtonInput::read($builder, $entry);

        foreach ($builder->getButtons() as $button) {
            if (!array_get($button, 'enabled', true)) {
                continue;
            }

            $button = $this->evaluator->evaluate($button, compact('entry', 'tree'));
            $button = $this->parser->parse($button, $entry);

            $button = $this->factory->make($button);

            $buttons->push($button);
        }

        return $buttons;
    }
}
