<?php namespace Anomaly\Streams\Platform\Support;

use Anomaly\Streams\Platform\Model\Contract\EloquentRepositoryInterface;

class Getter
{

    /**
     * The repository
     *
     * @var EloquentRepositoryInterface
     */
    protected $repository;

    /**
     * The identifier
     *
     * @var mixed
     */
    protected $identifier;

    /**
     * Create an instance of a getter class
     *
     * @param      EloquentRepositoryInterface  $repository  The repository
     * @param      mixed                        $identifier  The identifier
     */
    public function __construct(
        EloquentRepositoryInterface $repository,
        $identifier
    )
    {
        $this->repository = $repository;
        $this->identifier = $identifier;
    }

    /**
     * Get the object
     *
     * @return     EloquentModel|null
     */
    public function get()
    {
        if (is_numeric($this->identifier)) {
            return $this->repository->find($this->identifier);
        }

        if (is_string($this->identifier) && method_exists($this->repository, 'findBySlug')) {
            return $this->repository->findBySlug($this->identifier);
        }

        if ($this->identifier instanceof Presenter) {
            return $this->identifier->getObject();
        }

        if (is_object($this->identifier)) {
            return $this->identifier;
        }

        return null;
    }
}
