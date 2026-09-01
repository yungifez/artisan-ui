<?php

namespace Yungifez\AprilUI\Console\Commands;

use Illuminate\Console\Command;
use Yungifez\AprilUI\Mcp\Server;
use Yungifez\AprilUI\Registry;

class McpCommand extends Command
{
    protected $signature = 'april:mcp {--path= : Laravel project base path}';

    protected $description = 'Run the April UI MCP server over standard input and output';

    public function handle(Registry $registry): int
    {
        $basePath = $this->option('path') ?: base_path();

        return (new Server($registry, rtrim($basePath, '/')))->run(STDIN, STDOUT);
    }
}
