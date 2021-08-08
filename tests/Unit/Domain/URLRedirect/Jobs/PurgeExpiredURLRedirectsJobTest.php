<?php

namespace Tests\Unit\Domain\URLRedirect\Jobs;

use App\Domain\URLRedirect\Jobs\PurgeExpiredURLRedirectsJob;
use App\Domain\URLRedirect\URLRedirect;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurgeExpiredURLRedirectsJobTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test purge deleted urls
     *
     * @return void
     */
    public function test_purge_deleted()
    {
        Carbon::setTestNow('2021-08-08 10:10:10'); 

        $url_redirect = URLRedirect::factory()->create([
            'delete_at' => Carbon::now()->subDays(1),
            'deleted_at' => null
        ]);

        PurgeExpiredURLRedirectsJob::dispatchSync();

        $url_redirect->refresh();
        $this->assertEquals($url_redirect->deleted_at, Carbon::now());
    }
}
