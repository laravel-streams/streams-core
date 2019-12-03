<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Action;

use Anomaly\Streams\Platform\Ui\Button\ButtonRegistry;
use Anomaly\Streams\Platform\Ui\Support\Normalizer;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionRegistry;

/**
 * Class ActionInput
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ActionInput
{

    /**
     * Read builder action input.
     *
     * @param  TableBuilder $builder
     * @return array
     */
    public static function read(TableBuilder $builder)
    {
        self::resolve($builder);
        self::predict($builder);
        self::normalize($builder);
        self::merge($builder);

        ActionGuesser::guess($builder);

        self::translate($builder);
        self::parse($builder);
    }

    /**
     * Resolve input.
     *
     * @param \Anomaly\Streams\Platform\Ui\Table\TableBuilder $builder
     */
    protected static function resolve(TableBuilder $builder)
    {
        $actions = resolver($builder->getActions(), compact('builder'));

        $builder->setActions(evaluate($actions ?: $builder->getActions(), compact('builder')));
    }

    /**
     * Evaluate input.
     *
     * @param \Anomaly\Streams\Platform\Ui\Table\TableBuilder $builder
     */
    protected static function evaluate(TableBuilder $builder)
    {
        $builder->setActions(evaluate($builder->getActions(), compact('builder')));
    }

    /**
     * Predict input.
     *
     * @param \Anomaly\Streams\Platform\Ui\Table\TableBuilder $builder
     */
    protected static function predict(TableBuilder $builder)
    {
        if ($builder->getTableOption('sortable')) {
            $builder->setActions(array_merge(['reorder'], $builder->getActions()));
        }
    }

    /**
     * Normalize action input.
     *
     * @param TableBuilder $builder
     */
    protected static function normalize(TableBuilder $builder)
    {
        $actions = $builder->getActions();
        $prefix  = $builder->getTableOption('prefix');

        foreach ($actions as $slug => &$action) {

            /*
            * If the slug is numeric and the action is
            * a string then treat the string as both the
            * action and the slug. This is OK as long as
            * there are not multiple instances of this
            * input using the same action which is not likely.
            */
            if (is_numeric($slug) && is_string($action)) {
                $action = [
                    'slug'   => $action,
                    'action' => $action,
                ];
            }

            /*
            * If the slug is NOT numeric and the action is a
            * string then use the slug as the slug and the
            * action as the action.
            */
            if (!is_numeric($slug) && is_string($action)) {
                $action = [
                    'slug'   => $slug,
                    'action' => $action,
                ];
            }

            /*
            * If the slug is not numeric and the action is an
            * array without a slug then use the slug for
            * the slug for the action.
            */
            if (is_array($action) && !isset($action['slug']) && !is_numeric($slug)) {
                $action['slug'] = $slug;
            }

            /*
            * If the slug is not numeric and the action is an
            * array without a action then use the slug for
            * the action for the action.
            */
            if (is_array($action) && !isset($action['action']) && !is_numeric($slug)) {
                $action['action'] = $slug;
            }

            /*
            * Set defaults as expected for actions.
            */
            $action['disabled'] = array_get($action, 'disabled', array_get($action, 'toggle', true));

            $action['attributes']['name']  = $prefix . 'action';
            $action['attributes']['value'] = $action['slug'];

            // If not toggle add the ignore attribute.
            if (array_get($action, 'toggle', true) === false) {
                $action['attributes']['data-ignore'] = '';
            }
        }

        $actions = Normalizer::attributes($actions);

        $builder->setActions($actions);
    }

    /**
     * Merge in registered parameters.
     *
     * @param TableBuilder $builder
     */
    protected static function merge(TableBuilder $builder)
    {
        $actions = $builder->getActions();

        foreach ($actions as &$parameters) {

            $action = $original = array_pull($parameters, 'action');

            if ($action && $action = app(ActionRegistry::class)->get($action)) {
                $parameters = array_replace_recursive($action, array_except($parameters, 'action'));
            }

            $button = array_get($parameters, 'button', $original);

            if ($button && $button = app(ButtonRegistry::class)->get($button)) {
                $parameters = array_replace_recursive($button, array_except($parameters, 'button'));
            }
        }

        $builder->setActions($actions);
    }

    /**
     * Parse input.
     *
     * @param \Anomaly\Streams\Platform\Ui\Table\TableBuilder $builder
     */
    protected static function parse(TableBuilder $builder)
    {
        $builder->setActions(parse($builder->getActions()));
    }

    /**
     * Translate input.
     *
     * @param \Anomaly\Streams\Platform\Ui\Table\TableBuilder $builder
     */
    protected static function translate(TableBuilder $builder)
    {
        $builder->setActions(translate($builder->getActions()));
    }
}
