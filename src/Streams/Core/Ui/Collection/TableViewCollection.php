<?php namespace Streams\Core\Ui\Collection;

use Streams\Core\Support\Collection;
use Streams\Core\Ui\Support\TableView;
use Streams\Core\Ui\Contract\TableViewInterface;

class TableViewCollection extends Collection
{
    /**
     * Create a new TableViewCollection instance.
     *
     * @param array $items
     */
    public function __construct($items = [])
    {
        foreach ($items as $k => &$item) {
            if (!$item instanceof TableViewInterface) {
                $item = new TableView($item);
            }

            if (\Input::get('view') == $item->getSlug()) {
                $item->setActive(true);
            } elseif (!\Input::has('view') and $k == 0) {
                $item->setActive(true);
            }
        }

        parent::__construct($items);
    }

    /**
     * Return the active view.
     *
     * @return mixed|null
     */
    public function active()
    {
        foreach ($this->items as $item) {
            if ($item->isActive()) {
                return $item;
            }
        }

        return $this->first();
    }

    /**
     * Find a vew by it's slug.
     *
     * @param $slug
     * @return null
     */
    public function findBySlug($slug)
    {
        foreach ($this->items as $item) {
            if ($item->getSlug() == $slug) {
                return $item;
            }
        }

        return null;
    }
}