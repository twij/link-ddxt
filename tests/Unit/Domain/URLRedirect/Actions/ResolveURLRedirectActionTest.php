<?php

namespace Tests\Unit\Domain\URLRedirect\Actions;

use App\Domain\URLRedirect\Actions\ResolveURLRedirectAction;
use App\Domain\URLRedirect\Jobs\HitURLRedirectJob;
use App\Domain\URLRedirect\URLRedirect;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

class ResolveURLRedirectActionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test valid tokens return url redirects
     *
     * @return void
     */
    public function test_resolve_url_valid_token()
    {
        $redirects = URLRedirect::factory()->count(10)->create();

        foreach($redirects as $redirect) {
            $action = $this->app->make(ResolveURLRedirectAction::class);
            
            $this->expectsJobs(HitURLRedirectJob::class);

            $result = $action->execute($redirect->token);
    
            $this->assertEquals($result, $redirect->url);
        }
    }

    /**
     * Test invalid token aborts with not found exception
     *
     * @return void
     */
    public function test_invalid_token_404()
    {
        $action = $this->app->make(ResolveURLRedirectAction::class);

        $this->expectException(NotFoundHttpException::class);

        $action->execute('test');
    }

    /**
     * Test deleted token aborts with not found exception
     *
     * @return void
     */
    public function test_deleted_token_410()
    {
        $redirect = URLRedirect::factory()->create([
            'deleted_at' => Carbon::now()->subDays(7)
        ]);

        $action = $this->app->make(ResolveURLRedirectAction::class);
        
        $this->expectException(NotFoundHttpException::class);

        $result = $action->execute($redirect->token);
    }
}
