<?php namespace Anomaly\Streams\Platform\Ui\Form\Section\Command;

use Anomaly\Streams\Platform\Ui\Form\Section\SectionFactory;

/**
 * Class BuildFormSectionsCommandHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form\Section\Command
 */
class BuildFormSectionsCommandHandler
{

    /**
     * The section factory.
     *
     * @var \Anomaly\Streams\Platform\Ui\Form\Section\SectionFactory
     */
    protected $factory;

    /**
     * Create a new BuildFormSectionsCommandHandler instance.
     *
     * @param SectionFactory $factory
     */
    public function __construct(SectionFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Handle the command.
     *
     * @param BuildFormSectionsCommand $command
     */
    public function handle(BuildFormSectionsCommand $command)
    {
        $builder  = $command->getBuilder();
        $form     = $builder->getForm();
        $sections = $form->getSections();
        $stream   = $form->getStream();
        $entry    = $form->getEntry();

        foreach ($builder->getSections() as $parameters) {
            $parameters['stream'] = $stream;
            $parameters['entry']  = $entry;
            $parameters['form']   = $form;

            $section = $this->factory->make($parameters);

            $sections->push($section);
        }
    }
}
