<?php namespace Anomaly\Streams\Platform\Ui\Table\View;

use Anomaly\Streams\Platform\Ui\Table\View\Contract\ViewInterface;
use Illuminate\Support\Collection;

/**
 * Class ViewCollection
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\View
 */
class ViewCollection extends Collection
{

    /**
     * Get the active view.
     *
     * @return ViewInterface|null
     */
    public function active()
    {
        foreach ($this->items as $item) {
            if ($this->viewIsActive($item)) {
                return $item;
            }
        }

        return null;
    }

    /**
     * Return whether the view is active or not.
     *
     * @param ViewInterface $item
     * @return mixed
     */
    protected function viewIsActive(ViewInterface $item)
    {
        return $item->isActive();
    }
}
