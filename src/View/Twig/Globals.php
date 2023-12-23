<?php namespace Anomaly\Streams\Platform\View\Twig;

use Twig\Environment;
use Twig\Extension\GlobalsInterface;

/**
 * This file is part of the TwigBridge package.
 *
 * @copyright Robert Crowe <hello@vivalacrowe.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

if (version_compare(Environment::VERSION, '1.23.0') === -1) {
    interface Globals
    {

    }
} else {
    interface Globals extends GlobalsInterface
    {

    }
}
