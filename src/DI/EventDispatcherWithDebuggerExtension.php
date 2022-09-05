<?php

declare(strict_types=1);

namespace Stefano\NetteEventLogger\DI;

use Contributte\EventDispatcher\DI\EventDispatcherExtension;
use Nette\PhpGenerator\ClassType;
use Stefano\NetteEventLogger\EventLoggerDispatcher;
use Stefano\NetteEventLogger\Logger\Logger;
use Stefano\NetteEventLogger\Tracy\EventTracyPanel;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Tracy\Debugger;

class EventDispatcherWithDebuggerExtension extends EventDispatcherExtension
{
    public function setConfig($config)
    {
        $config->lazy = true;

        return parent::setConfig($config);
    }

    public function loadConfiguration(): void
    {
        if (Debugger::$productionMode) {
            parent::loadConfiguration();

            return;
        }

        $builder = $this->getContainerBuilder();

        $eventDispatcherDefinition = $builder->addDefinition($this->prefix('dispatcher'))
            ->setType(EventDispatcherInterface::class);

        $this->getContainerBuilder()->addDefinition($this->prefix('logger'))
            ->setFactory(Logger::class);

        $eventDispatcherDefinition
            ->setFactory(EventLoggerDispatcher::class);

        $this->getContainerBuilder()->addDefinition($this->prefix('eventTracyPanel'))
            ->setFactory(EventTracyPanel::class);
    }

    public function afterCompile(ClassType $class): void
    {
        $initialize = $class->getMethod('initialize');
        $initialize->addBody('$this->getService(?)->addPanel($this->getService(?));', array('tracy.bar', $this->prefix('eventTracyPanel')));
    }
}
