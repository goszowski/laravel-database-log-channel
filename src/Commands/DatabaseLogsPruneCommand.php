<?php

namespace Goszowski\DatabaseLogChannel\Commands;

use Illuminate\Console\Command;
use DB;

class DatabaseLogsPruneCommand extends Command
{
    public $signature = 'database-logs:prune {--hours=24 : The number of hours to retain logs data}';

    public $description = 'Prune stale entries from the logs database';

    public function handle(): int
    {
        $prunedCount = DB::connection(config('logging.channels.database.connection'))->table(config('logging.channels.database.table'))->where('created_at', '<', now()->subHours($this->option('hours')))->delete();

        $this->info($prunedCount . ' records pruned.');

        return self::SUCCESS;
    }
}
