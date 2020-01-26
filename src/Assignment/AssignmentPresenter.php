<?php

namespace Anomaly\Streams\Platform\Assignment;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Model\EloquentPresenter;

/**
 * Class AssignmentPresenter
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AssignmentPresenter extends EloquentPresenter
{

    /**
     * The decorated object.
     * This is for IDE support.
     *
     * @var AssignmentInterface
     */
    protected $object;

    /**
     * Return the flag labels.
     *
     * @return string
     */
    public function labels()
    {
        return implode(
            ' ',
            [
                $this->requiredLabel(),
                $this->uniqueLabel(),
                $this->translatableLabel(),
            ]
        );
    }

    /**
     * Return the required label.
     *
     * @return null|string
     */
    protected function requiredLabel()
    {
        if ($this->object->isRequired()) {
            return '<span class="tag tag-danger">' . trans(
                'streams::assignment.required.name'
            ) . '</span>';
        }

        return null;
    }

    /**
     * Return the unique label.
     *
     * @return null|string
     */
    protected function uniqueLabel()
    {
        if ($this->object->isUnique()) {
            return '<span class="tag tag-primary">' . trans(
                'streams::assignment.unique.name'
            ) . '</span>';
        }

        return null;
    }

    /**
     * Return the translatable label.
     *
     * @return null|string
     */
    protected function translatableLabel()
    {
        if ($this->object->isTranslatable()) {
            return '<span class="tag tag-info">' . trans(
                'streams::assignment.translatable.name'
            ) . '</span>';
        }

        return null;
    }
}
