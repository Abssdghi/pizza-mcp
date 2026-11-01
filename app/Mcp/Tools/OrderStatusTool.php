<?php

namespace App\Mcp\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;

#[Description('Gets the current status of a pizza order by its ID.')]
class OrderStatusTool extends Tool
{
    private const ORDERS = [
        1 => 'baking',
        2 => 'out for delivery',
        3 => 'delivered',
    ];


    public function handle(Request $request): Response
    {
        $request->validate(['order_id' => 'required|integer']);

        $id = $request->get('order_id');

        return isset(self::ORDERS[$id])
            ? Response::text("Order #{$id} is: " . self::ORDERS[$id])
            : Response::error('No such order');
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'order_id' => $schema->integer()->description('The pizza order ID')->required(),
        ];
    }
}
