<?php namespace Anomaly\Streams\Platform\Ui\Table\Contract;

/**
 * Interface TableServiceInterface
 *
 * This interface helps assure that the table service
 * being used can at least return the required data.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Contract
 */
interface TableServiceInterface
{

    /**
     * Return the views data.
     *
     * @return mixed
     */
    public function views();

    /**
     * Return the filters data.
     *
     * @return mixed
     */
    public function filters();

    /**
     * Return the headers data.
     *
     * @return mixed
     */
    public function headers();

    /**
     * Return the row data.
     *
     * @return mixed
     */
    public function rows();

    /**
     * Return the actions data.
     *
     * @return mixed
     */
    public function actions();

    /**
     * Return the pagination data.
     *
     * @return mixed
     */
    public function pagination();

    /**
     * Return the options data.
     *
     * @return mixed
     */
    public function options();

}
 