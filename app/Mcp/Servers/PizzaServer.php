<?php

namespace App\Mcp\Servers;

use App\Mcp\Tools\OrderStatusTool;
use Laravel\Mcp\Server;
use Laravel\Mcp\Server\Attributes\Instructions;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Attributes\Version;

#[Name('Pizza Server')]
#[Version('0.0.1')]
#[Instructions('Answers customer questions about Y2K Pizza orders.')]
class PizzaServer extends Server
{
    protected array $tools = [
        OrderStatusTool::class,
    ];
}
