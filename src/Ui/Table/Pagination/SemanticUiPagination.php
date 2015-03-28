<?php namespace Anomaly\Streams\Platform\Ui\Table\Pagination;

use Anomaly\Streams\Platform\Ui\Table\Pagination\Contract\PaginationInterface;
use Illuminate\Pagination\BootstrapThreePresenter;

/**
 * Class SemanticUiPagination
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Pagination
 */
class SemanticUiPagination extends BootstrapThreePresenter implements PaginationInterface
{

    /**
     * Convert the URL window into Bootstrap HTML.
     *
     * @return string
     */
    public function render()
    {
        if ($this->hasPages()) {
            return sprintf(
                '<div class="ui pagination menu">%s %s %s</div>',
                $this->getPreviousButton('<i class="arrow left icon"></i>'),
                $this->getLinks(),
                $this->getNextButton('<i class="arrow right icon"></i>')
            );
        }

        return '';
    }

    /**
     * Get HTML wrapper for an available page link.
     *
     * @param  string      $url
     * @param  int         $page
     * @param  string|null $rel
     * @return string
     */
    protected function getAvailablePageWrapper($url, $page, $rel = null)
    {
        $rel = is_null($rel) ? '' : ' rel="' . $rel . '"';

        return '<a class="icon item" href="' . $url . '"' . $rel . '>' . $page . '</a>';
    }

    /**
     * Get HTML wrapper for disabled text.
     *
     * @param  string $text
     * @return string
     */
    protected function getDisabledTextWrapper($text)
    {
        return '<div class="disabled item">' . $text . '</div>';
    }

    /**
     * Get HTML wrapper for active text.
     *
     * @param  string $text
     * @return string
     */
    protected function getActivePageWrapper($text)
    {
        return '<div class="active item"><span>' . $text . '</span></div>';
    }

    /**
     * Get a pagination "dot" element.
     *
     * @return string
     */
    protected function getDots()
    {
        return $this->getDisabledTextWrapper("...");
    }

    /**
     * Get the current page from the paginator.
     *
     * @return int
     */
    protected function currentPage()
    {
        return $this->paginator->currentPage();
    }

    /**
     * Get the last page from the paginator.
     *
     * @return int
     */
    protected function lastPage()
    {
        return $this->paginator->lastPage();
    }
}
