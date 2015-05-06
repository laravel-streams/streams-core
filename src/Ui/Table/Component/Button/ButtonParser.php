<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Button;

use Anomaly\Streams\Platform\Support\Parser;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;

/**
 * Class ButtonParser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Button
 */
class ButtonParser
{

    /**
     * The parser utility.
     *
     * @var Parser
     */
    protected $parser;

    /**
     * The request object.
     *
     * @var Request
     */
    protected $request;

    /**
     * Create a new ButtonParser instance.
     *
     * @param Parser  $parser
     * @param Request $request
     */
    public function __construct(Parser $parser, Request $request)
    {
        $this->parser  = $parser;
        $this->request = $request;
    }

    /**
     * Parse the button with the entry.
     *
     * @param array $button
     * @param       $entry
     * @return mixed
     */
    public function parser(array $button, $entry)
    {
        $data = [
            'route'   => $this->getRoute(),
            'request' => $this->getRequest()
        ];

        if (is_object($entry) && $entry instanceof Arrayable) {
            $data['entry'] = $entry->toArray();
        }

        return $this->parser->parse($button, $data);
    }

    /**
     * Get the route array.
     *
     * @return array
     */
    protected function getRoute()
    {
        $route = $this->request->route();

        return [
            'parameters' => $route->parameters()
        ];
    }

    /**
     * Get the request array.
     *
     * @return string
     */
    protected function getRequest()
    {
        return [
            'path' => $this->request->path()
        ];
    }
}
