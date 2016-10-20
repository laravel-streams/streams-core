<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\View;

use Anomaly\Streams\Platform\Ui\Table\Component\View\Contract\ViewInterface;
use Anomaly\Streams\Platform\Ui\Table\Component\View\Contract\ViewQueryInterface;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ViewQuery
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ViewQuery
{

    /**
     * The service container.
     *
     * @var Container
     */
    protected $container;

    /**
     * Create a new ViewQuery instance.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Handle the view query.
     *
     * @param  TableBuilder  $builder
     * @param  Builder       $query
     * @param  ViewInterface $view
     * @return mixed
     * @throws \Exception
     */
    public function handle(TableBuilder $builder, Builder $query, ViewInterface $view)
    {
        $view->fire('querying', compact('builder', 'query'));

        if (!$handler = $view->getQuery()) {
            return;
        }

        // Self handling implies @handle
        if (is_string($handler) && !str_contains($handler, '@')) {
            $handler .= '@handle';
        }

        /*
         * If the handler is a callable string or Closure
         * then call it using the IoC container.
         */
        if (is_string($handler) || $handler instanceof \Closure) {
            $this->container->call($handler, compact('builder', 'query'));
        }

        /*
         * If the handle is an instance of ViewQueryInterface
         * simply call the handle method on it.
         */
        if ($handler instanceof ViewQueryInterface) {
            $handler->handle($builder, $query);
        }
    }
}
