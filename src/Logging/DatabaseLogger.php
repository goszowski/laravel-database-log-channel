<?php

namespace Goszowski\DatabaseLogChannel\Logging;

use Monolog\Logger;

class DatabaseLogger 
{
    public function __invoke(array $config)
    {
        $logger = new Logger('DatabaseLogHandler');
        return $logger->pushHandler(new DatabaseLogHandler);
    }
}