<?php

namespace Tests\Unit\Domain\URLRedirect\Actions;

use App\Domain\URLRedirect\Actions\CreateURLRedirectAction;
use App\Domain\URLRedirect\DataTransferObjects\URLRedirectDTO;
use App\Domain\URLRedirect\Exceptions\InvalidURLException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateURLRedirectActionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test URL Redirect creation passes without checking URL
     *
     * @return void
     */
    public function test_valid_url_passes_no_validation()
    {
        $action = $this->app->make(CreateURLRedirectAction::class);

        $payload = new URLRedirectDTO([
            'url' => 'https://google.com/',
            'check_url' => false
        ]);

        $result = $action->execute($payload);

        $this->assertArrayHasKey('url', $result);
        $this->assertDatabaseHas('url_redirects', [
            'id' => 1,
            'url' => 'https://google.com/',
            'hits' => 0,
        ]);
    }

    /**
     * Test URL Redirect creation passes with checking URL
     *
     * @return void
     */
    public function test_valid_url_passes_with_validation()
    {
        $action = $this->app->make(CreateURLRedirectAction::class);

        $payload = new URLRedirectDTO([
            'url' => 'https://google.com/',
            'check_url' => true
        ]);

        $result = $action->execute($payload);

        $this->assertArrayHasKey('url', $result);
        $this->assertDatabaseHas('url_redirects', [
            'id' => 1,
            'url' => 'https://google.com/',
            'hits' => 0,
        ]);
    }

    /**
     * Test URL Redirect creation passes without
     *
     * @return void
     */
    public function test_invalid_url_passes_no_validation()
    {
        $action = $this->app->make(CreateURLRedirectAction::class);

        $payload = new URLRedirectDTO([
            'url' => 'hxxps://google.com/',
            'check_url' => false
        ]);

        $result = $action->execute($payload);

        $this->assertArrayHasKey('url', $result);
        $this->assertDatabaseHas('url_redirects', [
            'id' => 1,
            'url' => 'hxxps://google.com/',
            'hits' => 0,
        ]);
    }

    /**
     * Test URL Redirect creation passes without
     *
     * @return void
     */
    public function test_invalid_url_fails_with_validation()
    {
        $action = $this->app->make(CreateURLRedirectAction::class);

        $payload = new URLRedirectDTO([
            'url' => 'hxxps://google.com/',
            'check_url' => true
        ]);

        $this->expectException(InvalidURLException::class);

        $result = $action->execute($payload);
    }
}
