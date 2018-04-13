<?php namespace Anomaly\Streams\Platform\Version\Table;

use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;
use Anomaly\Streams\Platform\Version\Contract\VersionInterface;

/**
 * Class VersionTableButtons
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class VersionTableButtons
{

    /**
     * Handle the command.
     *
     * @param VersionTableBuilder $builder
     * @param ControlPanelBuilder $controlPanel
     */
    public function handle(VersionTableBuilder $builder, ControlPanelBuilder $controlPanel)
    {
        $section = $controlPanel->getControlPanelActiveSection();

        $current = $builder->getCurrent();

        $builder->setButtons(
            [
                'changes' => [
                    'type' => 'info',
                    'icon' => 'code-fork',
                    'href' => $section->getHref('versions/changes/{entry.version}'),
                    'text' => function (VersionInterface $entry) {
                        return ($count = count($entry->getData())) . ' ' . trans_choice(
                                'streams::version.changes',
                                $count
                            );
                    },
                ],
                'load'    => [
                    'href'     => $section->getHref(
                        'edit/{entry.versionable_id}?version={entry.version}&versionable={entry.versionable_type}'
                    ),
                    'disabled' => function (VersionInterface $entry) use ($current) {

                        if ($current->getVersion() !== $entry->getVersion()) {
                            return false;
                        }

                        return true;
                    },
                ],
            ]
        );
    }
}
