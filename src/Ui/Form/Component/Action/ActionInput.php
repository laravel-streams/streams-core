<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Action;

use Illuminate\Support\Str;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Ui\Support\Normalizer;
use Anomaly\Streams\Platform\Ui\Button\ButtonRegistry;
use Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionRegistry;

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
     * @param FormBuilder $builder
     */
    public static function read(FormBuilder $builder)
    {
        self::resolve($builder);
        self::defaults($builder);
        self::predict($builder);
        self::normalize($builder);

        ActionGuesser::guess($builder);

        self::merge($builder);
        self::translate($builder);
        self::parse($builder);
    }

    /**
     * Resolve input.
     *
     * @param \Anomaly\Streams\Platform\Ui\Form\FormBuilder $builder
     */
    protected static function resolve(FormBuilder $builder)
    {
        $actions = resolver($builder->getActions(), compact('builder'));

        $builder->setActions(evaluate($actions ?: $builder->getActions(), compact('builder')));
    }

    /**
     * Evaluate input.
     *
     * @param \Anomaly\Streams\Platform\Ui\Form\FormBuilder $builder
     */
    protected static function evaluate(FormBuilder $builder)
    {
        $builder->setActions(evaluate($builder->getActions(), compact('builder')));
    }

    /**
     * Default the form actions when none are defined.
     *
     * @param FormBuilder $builder
     */
    protected static function defaults(FormBuilder $builder)
    {
        if ($builder->getActions() === []) {
            if ($builder->getFormMode() == 'create') {
                $builder->setActions(
                    [
                        'save',
                        'save_create',
                    ]
                );
            } else {
                $builder->setActions(
                    [
                        'update',
                        'save_exit',
                    ]
                );
            }
        }
    }

    /**
     * Predict input.
     *
     * @param \Anomaly\Streams\Platform\Ui\Form\FormBuilder $builder
     */
    protected static function predict(FormBuilder $builder)
    {
        if (array_filter(explode(',', $builder->getRequestValue('edit_next')))) {
            $builder->setActions(array_merge(['save_edit_next'], $builder->getActions()));
        }
    }

    /**
     * Normalize action input.
     *
     * @param FormBuilder $builder
     */
    protected static function normalize(FormBuilder $builder)
    {
        $form    = $builder->getForm();
        $actions = $builder->getActions();

        $prefix = $form->getOption('prefix');

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
        }

        $actions = Normalizer::attributes($actions);

        $builder->setActions($actions);
    }

    /**
     * Merge in registered properties.
     *
     * @param FormBuilder $builder
     */
    protected static function merge(FormBuilder $builder)
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
     * @param \Anomaly\Streams\Platform\Ui\Form\FormBuilder $builder
     */
    protected static function parse(FormBuilder $builder)
    {
        $builder->setActions(Str::parse($builder->getActions()));
    }

    /**
     * Translate input.
     *
     * @param \Anomaly\Streams\Platform\Ui\Form\FormBuilder $builder
     */
    protected static function translate(FormBuilder $builder)
    {
        $builder->setActions(translate($builder->getActions()));
    }
}
