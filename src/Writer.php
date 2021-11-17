<?php

namespace Goszowski\DatabaseLogChannel;

use DB;
use Exception;
use Log;

class Writer
{
    public function write(array $data)
    {
        try {
            DB::connection(config('logging.channels.database.connection'))->table(config('logging.channels.database.table'))->insert($data);
        } catch (Exception $e) {
            Log::channel(config('logging.channels.database.alternative-log-channel'))->error($e->getMessage());
        }
    }
}
