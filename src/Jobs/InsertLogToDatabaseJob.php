<?php

namespace Goszowski\DatabaseLogChannel\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Goszowski\DatabaseLogChannel\Writer;

class InsertLogToDatabaseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        public array $data,
    ) {}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        (new Writer)->write($this->data);
    }
}
