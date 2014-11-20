<?php namespace Anomaly\Streams\Platform\Stream\Contract;

use Anomaly\Streams\Platform\Assignment\AssignmentCollection;

/**
 * Interface StreamInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Stream\Contract
 */
interface StreamInterface
{

    /**
     * Get the namespace.
     *
     * @return mixed
     */
    public function getNamespace();

    /**
     * Get the slug.
     *
     * @return mixed
     */
    public function getSlug();

    /**
     * Get the prefix.
     *
     * @return mixed
     */
    public function getPrefix();

    /**
     * Get the name.
     *
     * @return mixed
     */
    public function getName();

    /**
     * Get the translatable flag.
     *
     * @return mixed
     */
    public function isTranslatable();

    /**
     * Get the related assignments.
     *
     * @return AssignmentCollection
     */
    public function getAssignments();
}
 