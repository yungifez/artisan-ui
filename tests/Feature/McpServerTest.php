<?php

use Illuminate\Support\Facades\File;
use Yungifez\AprilUI\Mcp\Server;
use Yungifez\AprilUI\Registry;

function mcpServer(): Server
{
    return new Server(app(Registry::class), base_path());
}

/**
 * Run the same newline-delimited protocol used by the Artisan command.
 *
 * @param  list<array<string, mixed>|string>  $requests
 * @return list<array<string, mixed>>
 */
function runMcpProtocol(array $requests, ?Server $server = null): array
{
    $input = fopen('php://memory', 'r+');
    $output = fopen('php://memory', 'w+');

    foreach ($requests as $request) {
        fwrite($input, is_string($request) ? $request : json_encode($request)."\n");
    }

    rewind($input);
    ($server ?: mcpServer())->run($input, $output);
    rewind($output);

    $responses = [];
    foreach (array_filter(explode("\n", trim(stream_get_contents($output)))) as $line) {
        $responses[] = json_decode($line, true);
    }

    return $responses;
}

describe('the April UI MCP server', function () {
    it('answers the initialize request', function () {
        $response = mcpServer()->handle([
            'jsonrpc' => '2.0',
            'id' => 1,
            'method' => 'initialize',
        ]);

        expect($response['result']['protocolVersion'])->toBe('2024-11-05')
            ->and($response['result']['serverInfo']['name'])->toBe('april-ui')
            ->and($response['result']['capabilities'])->toHaveKeys(['tools', 'resources']);
    });

    it('lists tools and component resources', function () {
        $tools = mcpServer()->handle(['jsonrpc' => '2.0', 'id' => 1, 'method' => 'tools/list']);
        $resources = mcpServer()->handle(['jsonrpc' => '2.0', 'id' => 2, 'method' => 'resources/list']);

        expect(array_column($tools['result']['tools'], 'name'))
            ->toContain('april_list', 'april_search', 'april_publish')
            ->and(count($resources['result']['resources']))->toBeGreaterThan(50);
    });

    it('returns component source through resources', function () {
        $response = mcpServer()->handle([
            'jsonrpc' => '2.0',
            'id' => 1,
            'method' => 'resources/read',
            'params' => ['uri' => 'april://component/button'],
        ]);

        expect($response['result']['contents'][0]['text'])
            ->toContain("@props(['type' => 'button'])", '<button');
    });

    it('supports component search and notifications', function () {
        $response = mcpServer()->handle([
            'jsonrpc' => '2.0',
            'id' => 1,
            'method' => 'tools/call',
            'params' => ['name' => 'april_search', 'arguments' => ['query' => 'calendar']],
        ]);

        expect($response['result']['structuredContent']['components'])->toContain('calendar')
            ->and(mcpServer()->handle(['jsonrpc' => '2.0', 'method' => 'notifications/initialized']))->toBeNull();
    });

    it('lists the full registry and returns manifest details for one component', function () {
        $all = mcpServer()->handle([
            'jsonrpc' => '2.0',
            'id' => 1,
            'method' => 'tools/call',
            'params' => ['name' => 'april_list', 'arguments' => []],
        ]);
        $component = mcpServer()->handle([
            'jsonrpc' => '2.0',
            'id' => 2,
            'method' => 'tools/call',
            'params' => ['name' => 'april_list', 'arguments' => ['component' => 'select']],
        ]);

        expect($all['result']['structuredContent']['components'])
            ->toHaveCount(count(componentNames()))
            ->toContain('button', 'select')
            ->and($component['result']['structuredContent'])
            ->toMatchArray(['name' => 'select'])
            ->and($component['result']['structuredContent']['dependencies'])->toContain('angle-down');
    });

    it('searches case-insensitively and returns all components for an empty query', function () {
        $matching = mcpServer()->handle([
            'jsonrpc' => '2.0',
            'id' => 1,
            'method' => 'tools/call',
            'params' => ['name' => 'april_search', 'arguments' => ['query' => 'CALENDAR']],
        ]);
        $all = mcpServer()->handle([
            'jsonrpc' => '2.0',
            'id' => 2,
            'method' => 'tools/call',
            'params' => ['name' => 'april_search', 'arguments' => ['query' => '']],
        ]);

        expect($matching['result']['structuredContent'])->toMatchArray([
            'query' => 'calendar',
            'components' => ['calendar'],
        ])
            ->and($all['result']['structuredContent']['components'])->toHaveCount(count(componentNames()));
    });

    it('serves the stdio protocol and omits notification responses', function () {
        $responses = runMcpProtocol([
            ['jsonrpc' => '2.0', 'id' => 1, 'method' => 'ping'],
            ['jsonrpc' => '2.0', 'method' => 'notifications/initialized'],
            ['jsonrpc' => '2.0', 'id' => 2, 'method' => 'tools/list'],
        ]);

        expect($responses)->toHaveCount(2)
            ->and($responses[0])->toMatchArray(['jsonrpc' => '2.0', 'id' => 1, 'result' => []])
            ->and($responses[1]['id'])->toBe(2);
    });

    it('returns JSON-RPC errors for malformed and unknown requests', function () {
        $responses = runMcpProtocol([
            "{not-json}\n",
            ['jsonrpc' => '2.0', 'id' => 3, 'method' => 'unknown/method'],
            ['jsonrpc' => '2.0', 'id' => 4, 'method' => 'tools/call', 'params' => ['name' => 'missing_tool']],
        ]);

        expect($responses)->toHaveCount(3)
            ->and($responses[0]['error']['code'])->toBe(-32700)
            ->and($responses[1]['error']['code'])->toBe(-32601)
            ->and($responses[2]['error']['code'])->toBe(-32602);
    });

    it('returns useful errors for invalid resource and tool arguments', function () {
        $unknownResource = mcpServer()->handle([
            'jsonrpc' => '2.0',
            'id' => 1,
            'method' => 'resources/read',
            'params' => ['uri' => 'april://component/missing'],
        ]);
        $emptyPublish = mcpServer()->handle([
            'jsonrpc' => '2.0',
            'id' => 2,
            'method' => 'tools/call',
            'params' => ['name' => 'april_publish', 'arguments' => ['components' => []]],
        ]);
        $scalarPublish = mcpServer()->handle([
            'jsonrpc' => '2.0',
            'id' => 3,
            'method' => 'tools/call',
            'params' => ['name' => 'april_publish', 'arguments' => ['components' => 'button']],
        ]);

        expect($unknownResource['error'])->toMatchArray(['code' => -32602])
            ->and($emptyPublish['error']['message'])->toContain('non-empty array')
            ->and($scalarPublish['error']['message'])->toContain('non-empty array');
    });

    it('publishes component files when called through MCP', function () {
        $basePath = sys_get_temp_dir().'/april-mcp-'.uniqid('', true);
        $server = new Server(app(Registry::class), $basePath);

        try {
            $responses = runMcpProtocol([
                [
                    'jsonrpc' => '2.0',
                    'id' => 5,
                    'method' => 'tools/call',
                    'params' => [
                        'name' => 'april_publish',
                        'arguments' => ['components' => ['select']],
                    ],
                ],
            ], $server);

            $target = $basePath.'/resources/views/vendor/april/components';

            expect($responses[0]['result']['structuredContent']['written'])
                ->toContain($target.'/select.blade.php', $target.'/angle-down.blade.php')
                ->and($target.'/select.blade.php')->toBeFile()
                ->and(file_get_contents($target.'/select.blade.php'))
                ->toBe(file_get_contents(componentPath('select')));
        } finally {
            File::deleteDirectory($basePath);
        }
    });

    it('skips existing MCP files unless force is requested', function () {
        $basePath = sys_get_temp_dir().'/april-mcp-'.uniqid('', true);
        $server = new Server(app(Registry::class), $basePath);

        try {
            $first = $server->handle([
                'jsonrpc' => '2.0',
                'id' => 2,
                'method' => 'tools/call',
                'params' => ['name' => 'april_publish', 'arguments' => ['components' => ['button']]],
            ]);
            $path = $basePath.'/resources/views/vendor/april/components/button.blade.php';
            File::put($path, 'local override');

            $skipped = $server->handle([
                'jsonrpc' => '2.0',
                'id' => 3,
                'method' => 'tools/call',
                'params' => ['name' => 'april_publish', 'arguments' => ['components' => ['button']]],
            ]);
            $forced = $server->handle([
                'jsonrpc' => '2.0',
                'id' => 4,
                'method' => 'tools/call',
                'params' => ['name' => 'april_publish', 'arguments' => ['components' => ['button'], 'force' => true]],
            ]);

            expect($first['result']['structuredContent']['written'])->toContain($path)
                ->and($skipped['result']['structuredContent']['skipped'])->toContain($path)
                ->and(file_get_contents($path))->toBe(file_get_contents(componentPath('button')))
                ->and($forced['result']['structuredContent']['written'])->toContain($path);
        } finally {
            File::deleteDirectory($basePath);
        }
    });
});

describe('the April UI MCP installer', function () {
    it('adds April UI to an existing MCP configuration', function () {
        $relativePath = '.mcp-test-'.uniqid('', true).'.json';
        $path = base_path($relativePath);

        File::put($path, json_encode([
            'mcpServers' => [
                'laravel-boost' => [
                    'command' => 'php',
                    'args' => ['artisan', 'boost:mcp'],
                ],
            ],
        ], JSON_PRETTY_PRINT));

        try {
            expect(Artisan::call('april:mcp:install', ['--config' => $relativePath]))->toBe(0);

            $configuration = json_decode((string) File::get($path), true);

            expect($configuration['mcpServers'])->toHaveKeys(['laravel-boost', 'april-ui'])
                ->and($configuration['mcpServers']['laravel-boost']['args'])->toBe(['artisan', 'boost:mcp'])
                ->and($configuration['mcpServers']['april-ui']['args'])->toBe(['artisan', 'april:mcp']);
        } finally {
            File::delete($path);
        }
    });

    it('does not overwrite an existing April UI definition without force', function () {
        $relativePath = '.mcp-test-'.uniqid('', true).'.json';
        $path = base_path($relativePath);
        $existing = [
            'mcpServers' => [
                'april-ui' => [
                    'command' => 'custom-april',
                    'args' => [],
                ],
            ],
        ];

        File::put($path, json_encode($existing, JSON_PRETTY_PRINT));

        try {
            expect(Artisan::call('april:mcp:install', ['--config' => $relativePath]))->toBe(0)
                ->and(json_decode((string) File::get($path), true))->toBe($existing);
        } finally {
            File::delete($path);
        }
    });

    it('rejects invalid MCP configuration JSON', function () {
        $relativePath = '.mcp-test-'.uniqid('', true).'.json';
        $path = base_path($relativePath);

        File::put($path, '{invalid');

        try {
            expect(Artisan::call('april:mcp:install', ['--config' => $relativePath]))->not->toBe(0);
        } finally {
            File::delete($path);
        }
    });
});
