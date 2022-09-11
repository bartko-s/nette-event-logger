<?php

declare(strict_types=1);

namespace Stefano\NetteEventLogger\Tracy;

use Latte\Engine;
use Stefano\NetteEventLogger\Logger\Logger;
use Tracy\IBarPanel;

class EventTracyPanel implements IBarPanel
{
    public function __construct(private Logger $logger)
    {
    }

    public function getTab()
    {
        $latte = new Engine();

        return $latte->renderToString(__DIR__.'/@Templates/eventTracyTab.latte', array(
            'logger' => $this->logger,
        ));
    }

    public function getPanel()
    {
        $latte = new Engine();

        return $latte->renderToString(__DIR__.'/@Templates/eventTracyPanel.latte', array(
            'logger' => $this->logger,
        ));
    }
}
