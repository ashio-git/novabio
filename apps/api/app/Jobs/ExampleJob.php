<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ExampleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $backoff = [10, 30, 60];
    public $timeout = 120;

    public function __construct(
        public string $message
    ) {}

    public function handle(): void
    {
        Log::info('ExampleJob executed', ['message' => $this->message]);
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('ExampleJob failed', [
            'message' => $this->message,
            'error' => $exception->getMessage()
        ]);
    }
}
