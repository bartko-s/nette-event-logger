<?php

declare(strict_types=1);

namespace Stefano\NetteEventLogger\Tracy;

use Nette\Bridges\ApplicationLatte\Template;
use Stefano\NetteEventLogger\Logger\Logger;
use Tracy\Debugger;

class EventTracyPanelTemplate extends Template
{
    public Logger $logger;
    public Debugger $debugger;
}
