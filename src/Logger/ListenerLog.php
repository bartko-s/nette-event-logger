<?php

declare(strict_types=1);

namespace Stefano\NetteEventLogger\Logger;

class ListenerLog
{
    public function __construct(
        private readonly float $time,
        private readonly string $listener,
        private readonly string $eventClass,
        private readonly string $eventInfo,
    ) {
    }

    public function getTime(): float
    {
        return $this->time;
    }

    public function getListener(): string
    {
        return $this->listener;
    }

    public function getEventClass(): string
    {
        return $this->eventClass;
    }

    public function getEventInfo(): string
    {
        return $this->eventInfo;
    }
}
