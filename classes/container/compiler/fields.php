<?php

namespace mageekguy\atoum\config\container\compiler;

use mageekguy\atoum;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class fields implements CompilerPassInterface
{
    protected $script;

    public function __construct(atoum\scripts\runner $script)
    {
        $this->script = $script;
    }

    public function process(ContainerBuilder $container)
    {
        if ($container->hasParameter('atoum.fields') === false)
        {
            return;
        }

        $reports = $container->getParameter('atoum.fields');

        foreach ($reports as $report => $fields)
        {
            if ($report === 'default')
            {
                $report = $this->script->addDefaultReport();
            }
            else
            {
                $report = $container->get($report);
            }

            foreach ($fields as $field)
            {
                $report->addField($container->get($field));
            }
        }
    }
} 