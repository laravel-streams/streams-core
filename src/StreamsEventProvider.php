<?php namespace Anomaly\Streams\Platform;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;

/**
 * Class StreamsEventProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform
 */
class StreamsEventProvider extends EventServiceProvider
{

    /**
     * Event listeners.
     *
     * @var array
     */
    protected $listen = [
        'Anomaly\Streams\Platform\Application\Event\ApplicationHasLoaded'        => [
            'Anomaly\Streams\Platform\Addon\Module\Listener\DetectActiveModule',
            'Anomaly\Streams\Platform\Application\Listener\CheckIfInstallerExists',
            'Anomaly\Streams\Platform\Ui\ControlPanel\Listener\LoadControlPanel',
            'Anomaly\Streams\Platform\Ui\Breadcrumb\Listener\GuessBreadcrumbs',
            'Anomaly\Streams\Platform\Ui\Breadcrumb\Listener\LoadBreadcrumbs'
        ],
        'Anomaly\Streams\Platform\Addon\Event\AddonsRegistered'                  => [
            'Anomaly\Streams\Platform\Addon\Theme\Listener\LoadActiveTheme' => -100,
        ],
        'Anomaly\Streams\Platform\Model\Event\ModelWasDeleted'                   => [
            'Anomaly\Streams\Platform\Model\Listener\DeleteTranslations'
        ],
        'Anomaly\Streams\Platform\View\Event\ViewComposed'                       => [
            'Anomaly\Streams\Platform\View\Listener\DecorateData',
            'Anomaly\Streams\Platform\View\Listener\LoadTemplateData'
        ],
        'Anomaly\Streams\Platform\Stream\Event\StreamWasCreated'                 => [
            'Anomaly\Streams\Platform\Stream\Listener\CreateTable'
        ],
        'Anomaly\Streams\Platform\Stream\Event\StreamWasDeleted'                 => [
            'Anomaly\Streams\Platform\Stream\Listener\DropTable'
        ],
        'Anomaly\Streams\Platform\Assignment\Event\FieldWasUpdated'              => [
            'Anomaly\Streams\Platform\Field\Listener\RenameTableColumns'
        ],
        'Anomaly\Streams\Platform\Assignment\Event\AssignmentWasCreated'         => [
            'Anomaly\Streams\Platform\Assignment\Listener\AddTableColumn'
        ],
        'Anomaly\Streams\Platform\Assignment\Event\AssignmentWasUpdated'         => [
            'Anomaly\Streams\Platform\Assignment\Listener\ChangeTableColumn'
        ],
        'Anomaly\Streams\Platform\Assignment\Event\AssignmentWasDeleted'         => [
            'Anomaly\Streams\Platform\Assignment\Listener\DropTableColumn'
        ],
        'Anomaly\Streams\Platform\Addon\Module\Event\ModuleWasRegistered'        => [
            'Anomaly\Streams\Platform\Addon\Module\Listener\PutModuleInCollection'
        ],
        'Anomaly\Streams\Platform\Addon\Module\Event\ModuleWasInstalled'         => [
            'Anomaly\Streams\Platform\Addon\Module\Listener\MarkModuleInstalled'
        ],
        'Anomaly\Streams\Platform\Addon\Module\Event\ModuleWasUninstalled'       => [
            'Anomaly\Streams\Platform\Addon\Module\Listener\MarkModuleUninstalled'
        ],
        'Anomaly\Streams\Platform\Addon\Extension\Event\ExtensionWasRegistered'  => [
            'Anomaly\Streams\Platform\Addon\Extension\Listener\PutExtensionInCollection'
        ],
        'Anomaly\Streams\Platform\Addon\Extension\Event\ExtensionWasInstalled'   => [
            'Anomaly\Streams\Platform\Addon\Extension\Listener\MarkExtensionInstalled'
        ],
        'Anomaly\Streams\Platform\Addon\Extension\Event\ExtensionWasUninstalled' => [
            'Anomaly\Streams\Platform\Addon\Extension\Listener\MarkExtensionUninstalled'
        ],
        'Anomaly\Streams\Platform\Addon\FieldType\Event\FieldTypeWasRegistered'  => [
            'Anomaly\Streams\Platform\Addon\FieldType\Listener\PutFieldTypeInCollection'
        ],
        'Anomaly\Streams\Platform\Addon\Plugin\Event\PluginWasRegistered'        => [
            'Anomaly\Streams\Platform\Addon\Plugin\Listener\PutPluginInCollection',
            'Anomaly\Streams\Platform\Addon\Plugin\Listener\AddPluginToTwig'
        ],
        'Anomaly\Streams\Platform\Addon\Theme\Event\ThemeWasRegistered'          => [
            'Anomaly\Streams\Platform\Addon\Theme\Listener\PutThemeInCollection'
        ],
        'Anomaly\Streams\Platform\Ui\Table\Event\TableIsQuerying'                => [
            'Anomaly\Streams\Platform\Ui\Table\Component\View\Listener\ApplyView',
            'Anomaly\Streams\Platform\Ui\Table\Component\Filter\Listener\FilterResults'
        ]
    ];

    /**
     * Register the application's event listeners.
     *
     * @param  Dispatcher $events
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        foreach ($this->listen as $event => $listeners) {
            foreach ($listeners as $key => $listener) {

                if (is_integer($listener)) {
                    $listener = $key;
                    $priority = $listener;
                } else {
                    $priority = 0;
                }

                $events->listen($event, $listener, $priority);
            }
        }

        foreach ($this->subscribe as $subscriber) {
            $events->subscribe($subscriber);
        }
    }
}
