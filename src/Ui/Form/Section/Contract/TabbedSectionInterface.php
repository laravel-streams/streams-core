<?php namespace Anomaly\Streams\Platform\Ui\Form\Section\Contract;

/**
 * Interface TabbedSectionInterface
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form\Section\Contract
 */
interface TabbedSectionInterface
{

    /**
     * Return the view data.
     *
     * @param  array $arguments
     * @return mixed
     */
    public function viewData(array $arguments = []);

    /**
     * Set the tabs.
     *
     * @param  $tabs
     * @return mixed
     */
    public function setTabs($tabs);

    /**
     * Get the tabs.
     *
     * @return mixed
     */
    public function getTabs();
}
