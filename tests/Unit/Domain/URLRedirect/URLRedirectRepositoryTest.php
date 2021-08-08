<?php

namespace Tests\Unit\Domain\URLRedirect\Jobs;

use App\Domain\URLRedirect\Contracts\URLRedirectRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class URLRedirectRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test url redirect repository get unique token
     *
     * @return void
     */
    public function test_url_redirect_respoitory_get_unique_token()
    {
        $repository = App::make(URLRedirectRepositoryInterface::class);

        $token = $repository->getUniqueToken();

        $this->assertIsString($token);

        $this->assertDatabaseMissing('url_redirects', [
            'token' => $token
        ]);
    }
}
