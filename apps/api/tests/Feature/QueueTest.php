<?php

namespace Tests\Feature;

use App\Jobs\ExampleJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class QueueTest extends TestCase
{
    use RefreshDatabase;

    public function test_job_can_be_dispatched(): void
    {
        Queue::fake();

        ExampleJob::dispatch('test message');

        Queue::assertPushed(ExampleJob::class, function ($job) {
            return $job->message === 'test message';
        });
    }

    public function test_failed_jobs_table_exists(): void
    {
        $this->assertDatabaseCount('failed_jobs', 0);
    }

    public function test_job_batches_table_exists(): void
    {
        $this->assertDatabaseCount('job_batches', 0);
    }
}
