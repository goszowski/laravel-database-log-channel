<?php

namespace Goszowski\DatabaseLogChannel\Logging;

use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;
use Carbon\Carbon;
use Str;
use Goszowski\DatabaseLogChannel\Jobs\InsertLogToDatabaseJob;
use Goszowski\DatabaseLogChannel\Writer;

class DatabaseLogHandler extends AbstractProcessingHandler
{
    protected function write(array $record):void
    {
        $data = [
            'id' => Str::uuid()->toString(),
            'app' => config('app.name'),
            'message' => $record['message'],
            'context' => json_encode($record['context']),
            'level' => $record['level'],
            'level_name' => $record['level_name'],
            'channel' => $record['channel'],
            'record_datetime' => $record['datetime']->format('Y-m-d H:i:s.u'),
            'extra' => json_encode($record['extra']),
            'formatted' => $record['formatted'],
            'remote_addr' => $_SERVER['REMOTE_ADDR'] ?? null,
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
        ];

        if(config('logging.channels.database.async'))
        {
            InsertLogToDatabaseJob::dispatch($data);
        }
        else
        {
            (new Writer)->write($data);
        }
    }
}