# pizza-mcp

A tiny Laravel MCP server that lets an AI client check the status of a pizza order.

Built as a learning project for [Laravel MCP](https://laravel.com/docs/mcp), the official package for exposing a Laravel app to AI clients through the Model Context Protocol (MCP).

## What is this?

MCP is a standard way for an AI to discover what an application can do and call those actions on its own. In this project, the app publishes a single tool, `OrderStatusTool`, and any MCP-compatible client can use it to answer questions like "Where is my pizza? My order number is 2."

There is no database. Orders are hardcoded in the tool so the demo runs anywhere.

## How it works

1. The AI client connects to `/mcp/pizza`.
2. It reads the list of available tools and their input schemas.
3. It calls `OrderStatusTool` with an `order_id`.
4. The tool returns the order status as text.

## Project structure

| File | Purpose |
| --- | --- |
| `app/Mcp/Tools/OrderStatusTool.php` | The tool: input schema plus lookup logic |
| `app/Mcp/Servers/PizzaServer.php` | The server that registers the tool |
| `routes/ai.php` | Exposes the server over HTTP and as a local command |

## Getting started

```bash
composer install
php artisan serve
```

## Testing with the MCP Inspector

In a second terminal, start the Inspector:

```bash
npx @modelcontextprotocol/inspector
```

The terminal prints a session token and a link with the token pre-filled. Open that link in your browser, choose the `Streamable HTTP` transport, enter `http://localhost:8000/mcp/pizza` as the URL, and click Connect. Then open the Tools tab, pick `OrderStatusTool`, set `order_id` to `1`, and run it.

Note: the built-in `php artisan mcp:inspector` command may fail with newer Inspector versions, so running it directly with `npx` is more reliable.

## Connecting a real AI client

### Claude Code

With the server running (`php artisan serve`):

```bash
claude mcp add --transport http pizza http://localhost:8000/mcp/pizza
```

Then ask something like "What is the status of pizza order 2?"

### Claude Desktop

Claude Desktop starts the server itself as a local command, so no web server is needed. Add this to `claude_desktop_config.json` and restart the app:

```json
{
  "mcpServers": {
    "pizza": {
      "command": "php",
      "args": ["/absolute/path/to/pizza-mcp/artisan", "mcp:start", "pizza"]
    }
  }
}
```

## Sample data

| Order ID | Status |
| --- | --- |
| 1 | baking |
| 2 | out for delivery |
| 3 | delivered |

Any other ID returns an error response.

## Notes

- No authentication is applied. This is a local demo with fake data.
- Before exposing the server on a public URL, add middleware in `routes/ai.php` (for example `auth:sanctum` or OAuth), just like a normal Laravel route.

## Built with

- Laravel
- laravel/mcp