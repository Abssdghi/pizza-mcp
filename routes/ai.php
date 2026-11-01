<?php

use App\Mcp\Servers\PizzaServer;
use Laravel\Mcp\Facades\Mcp;

Mcp::web('/mcp/pizza', PizzaServer::class);
Mcp::local('pizza', PizzaServer::class);