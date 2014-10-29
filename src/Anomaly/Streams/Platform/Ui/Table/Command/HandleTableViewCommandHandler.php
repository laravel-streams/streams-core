<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Illuminate\Http\Request;
use Anomaly\Streams\Platform\Ui\Table\Contract\TableViewInterface;

class HandleTableViewCommandHandler
{
    protected $request;

    function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function handle(HandleTableViewCommand $command)
    {
        $ui    = $command->getUi();
        $query = $command->getQuery();

        foreach ($ui->getViews() as $order => $view) {

            $slug = $view['slug'];

            if (($slug and $slug == $this->request->get('_view')) or (!$this->request->get('_view') and $order == 0)) {

                $handler = $view['handler'];

                if (is_string($handler)) {

                    $handler = app($handler);

                }

                if ($handler instanceof \Closure) {

                    if ($result = $handler($query)) {

                        $query = $result;

                    }

                }

                if ($handler instanceof TableViewInterface) {

                    if ($result = $handler->handle($query)) {

                        $query = $result;

                    }

                }

            }

        }

        return $query;
    }
}
 