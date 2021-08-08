<?php

namespace Tests\Unit\Domain\URLRedirect\Jobs;

use App\Domain\URLRedirect\Jobs\HitURLRedirectJob;
use App\Domain\URLRedirect\URLRedirect;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HitURLRedirectJobTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test hit url redirect
     *
     * @return void
     */
    public function test_hit_url_redirect()
    {
        $url_redirect = URLRedirect::factory()->create();

        $previous_hits = $url_redirect->hits;

        HitURLRedirectJob::dispatchSync($url_redirect->token);

        $url_redirect->refresh();

        $this->assertEquals($url_redirect->hits, $previous_hits + 1);
    }
}
