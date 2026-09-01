<?php

namespace Yungifez\AprilUI\Mcp;

class McpError extends \RuntimeException
{
    public function __construct(public int $errorCode, string $message)
    {
        parent::__construct($message, $errorCode);
    }
}
