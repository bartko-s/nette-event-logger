<?php

declare(strict_types=1);

namespace Stefano\NetteEventLogger;

use Contributte\EventDispatcher\LazyEventDispatcher;
use Nette\DI\Container;
use Stefano\NetteEventLogger\Logger\EventLog;
use Stefano\NetteEventLogger\Logger\ListenerLog;
use Stefano\NetteEventLogger\Logger\Logger;

class EventLoggerDispatcher extends LazyEventDispatcher
{
    private Logger $logger;

    public function __construct(Container $container, Logger $logger)
    {
        parent::__construct($container);
        $this->logger = $logger;
    }

    public function dispatch(object $event, string $eventName = null): object
    {
        $eventInfo = method_exists($event, '__toString') ? (string) $event : null;

        $start = microtime(true) * 1000;
        $r = parent::dispatch($event, $eventName);
        $log = new EventLog((microtime(true) * 1000) - $start, $event::class, $eventName, $eventInfo);
        $this->logger->logEvent($log);

        return $r;
    }

    /**
     * Triggers the listeners of an event.
     *
     * This method can be overridden to add functionality that is executed
     * for each listener.
     *
     * @param callable[] $listeners The event listeners
     * @param string     $eventName The name of the event to dispatch
     * @param object     $event     The event object to pass to the event handlers/listeners
     */
    protected function callListeners(iterable $listeners, string $eventName, object $event)
    {
        foreach ($listeners as $listener) {
            $start = microtime(true) * 1000;
            parent::callListeners(array($listener), $eventName, $event);
//            bdump($listener);
//            bdump($eventName);
//            bdump($event);
            $log = new ListenerLog(
                (microtime(true) * 1000) - $start,
                $this->createListenerName($listener),
                $eventName,
                method_exists($event, '__toString') ? (string) $event : '',
            );
            $this->logger->logListener($log);
        }
    }

    private function createListenerName($listener): string
    {
        if (is_array($listener)) {
            return $listener[0]::class.':'.$listener[1];
        }

        return 'Cannot convert to string';
    }
}
