<?php

namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section;

use Anomaly\Streams\Platform\Support\Collection;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Contract\SectionInterface;

/**
 * Class SectionCollection
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SectionCollection extends Collection
{

    /**
     * Return the active section.
     *
     * @return null|SectionInterface
     */
    public function active()
    {
        /* @var SectionInterface $item */
        foreach ($this->items as $item) {
            if ($item->isActive()) {
                return $item;
            }
        }

        return null;
    }

    /**
     * Return only root sections.
     *
     * @return SectionCollection
     */
    public function root()
    {
        return $this->filter(function (SectionInterface $section) {
            return !$section->isSubSection();
        });
    }

    /**
     * Return only visible sections.
     *
     * @return SectionCollection
     */
    public function visible()
    {
        return $this->filter(function (SectionInterface $section) {
            return !$section->isHidden();
        });
    }

    /**
     * Return only sections with parent.
     *
     * @param $parent
     * @return static
     */
    public function children($parent)
    {
        return $this->filter(function (SectionInterface $section) use ($parent) {
            return $section->getParent() === $parent;
        });
    }
}
