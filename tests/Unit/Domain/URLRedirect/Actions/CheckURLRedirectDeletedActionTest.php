<?php

namespace Tests\Unit\Domain\URLRedirect\Actions;

use App\Domain\URLRedirect\Actions\CheckURLRedirectDeletedAction;
use App\Domain\URLRedirect\URLRedirect;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckURLRedirectDeletedActionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test deleted url reirect returns true
     *
     * @return void
     */
    public function test_deleted_at_returns_true()
    {
        $redirect = URLRedirect::factory()->create([
            'deleted_at' => Carbon::now()->subDays(7)
        ]);

        $action = $this->app->make(CheckURLRedirectDeletedAction::class);

        $result = $action->execute($redirect);

        $this->assertTrue($result);
    }

    /**
     * Test deleted url reirect returns true
     *
     * @return void
     */
    public function test_not_deleted_at_returns_false()
    {
        $redirect = URLRedirect::factory()->create([
            'deleted_at' => null
        ]);

        $action = $this->app->make(CheckURLRedirectDeletedAction::class);

        $result = $action->execute($redirect);

        $this->assertFalse($result);
    }

    /**
     * Test delete at in the past reirect returns true
     *
     * @return void
     */
    public function test_past_delete_at_returns_true()
    {
        $redirect = URLRedirect::factory()->create([
            'delete_at' => Carbon::now()->subDays(7)
        ]);

        $action = $this->app->make(CheckURLRedirectDeletedAction::class);

        $result = $action->execute($redirect);

        $this->assertTrue($result);
    }

    /**
     * Test delete at in future returns false
     *
     * @return void
     */
    public function test_future_deleted_at_returns_false()
    {
        $redirect = URLRedirect::factory()->create([
            'delete_at' => Carbon::now()->addDays(7)
        ]);

        $action = $this->app->make(CheckURLRedirectDeletedAction::class);

        $result = $action->execute($redirect);

        $this->assertFalse($result);
    }
}
