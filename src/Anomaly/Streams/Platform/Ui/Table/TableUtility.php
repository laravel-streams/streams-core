<?php namespace Anomaly\Streams\Platform\Ui\Table;

use Anomaly\Streams\Platform\Ui\Utility;

/**
 * Class TableUtility
 * Simple utility methods to assist table command handlers.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table
 */
class TableUtility extends Utility
{

    /**
     * Return default button configuration for
     * a given button type.
     *
     * @param $type
     * @return null
     */
    public function getButtonDefaults($type)
    {
        if (isset($this->buttons[$type]) and $defaults = $this->buttons[$type]) {

            $this->guessUrl($type, $defaults);

            return $defaults;

        }

        return null;
    }


    /**
     * Return default button configuration for
     * a given action type.
     *
     * @param $type
     * @return null
     */
    public function getActionDefaults($type)
    {
        if (isset($this->buttons[$type]) and $defaults = $this->buttons[$type]) {

            //$this->guessAction($type, $defaults);

            return $defaults;

        }

        return null;
    }

    /**
     * Try and guess a URL because we're awesome.
     * This of course can be overridden by setting one.
     *
     * @param $type
     * @param $defaults
     */
    protected function guessUrl($type, &$defaults)
    {
        $path = $this->router->getCurrentRoute()->getPath();

        switch ($type) {

            case 'view':
                $defaults['url'] = $path .= '/show/{id}';
                break;

            case 'edit':
                $defaults['url'] = $path .= '/edit/{id}';
                break;

            case 'delete':
                $defaults['url'] = $path .= '/delete/{id}';
                break;
        }
    }

}
 