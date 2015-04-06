<?php namespace Anomaly\Streams\Platform;

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
            'Anomaly\Streams\Platform\Application\Listener\CheckIfInstallerExists'
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
        'Anomaly\Streams\Platform\Assignment\Event\AssignmentWasCreated'         => [
            'Anomaly\Streams\Platform\Assignment\Listener\AddTableColumn'
        ],
        'Anomaly\Streams\Platform\Assignment\Event\AssignmentWasDeleted'         => [
            'Anomaly\Streams\Platform\Assignment\Listener\DropTableColumn'
        ],
        'Anomaly\Streams\Platform\Addon\Event\AddonsRegistered'                  => [
            'Anomaly\Streams\Platform\Addon\Module\Listener\DetectActiveModule',
            'Anomaly\Streams\Platform\Addon\Theme\Listener\DetectActiveTheme'
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
        'Anomaly\Streams\Platform\Addon\Block\Event\BlockWasRegistered'          => [
            'Anomaly\Streams\Platform\Addon\Block\Listener\PutBlockInCollection'
        ],
        'Anomaly\Streams\Platform\Addon\Theme\Event\ThemeWasRegistered'          => [
            'Anomaly\Streams\Platform\Addon\Theme\Listener\PutThemeInCollection'
        ],
        'Anomaly\Streams\Platform\Ui\Form\Event\ValidationFailed'                => [
            'Anomaly\Streams\Platform\Ui\Form\Listener\RepopulateFields',
            'Anomaly\Streams\Platform\Ui\Form\Listener\AddErrorMessages'
        ],
        'Anomaly\Streams\Platform\Ui\Form\Event\FormIsPosting'                   => [
            'Anomaly\Streams\Platform\Ui\Form\Listener\RemoveDisabledFields',
            'Anomaly\Streams\Platform\Ui\Form\Listener\LoadFormValues'
        ],
        'Anomaly\Streams\Platform\Ui\Form\Event\FormWasPosted'                   => [
            'Anomaly\Streams\Platform\Ui\Form\Listener\ValidateForm',
            'Anomaly\Streams\Platform\Ui\Form\Listener\HandleForm',
            'Anomaly\Streams\Platform\Ui\Form\Listener\SetFormResponse'
        ],
        'Anomaly\Streams\Platform\Ui\Table\Event\TableIsQuerying'                => [
            'Anomaly\Streams\Platform\Ui\Table\Component\View\Listener\ApplyView',
            'Anomaly\Streams\Platform\Ui\Table\Component\Filter\Listener\FilterResults',
            'Anomaly\Streams\Platform\Ui\Table\Component\Column\Listener\OrderResults'
        ]
    ];

}
