<?php

namespace Tests\Unit\Domain\URLRedirect\Actions;

use App\Domain\URLRedirect\Actions\CheckURLIsValidAction;
use App\Domain\URLRedirect\Exceptions\InvalidURLException;
use Tests\TestCase;

class CheckURLIsValidActionTest extends TestCase
{
    /**
     * Test valid url passes with true
     *
     * @return void
     */
    public function test_valid_url_passes()
    {
        $action = $this->app->make(CheckURLIsValidAction::class);

        $result = $action->execute('https://google.com/');

        $this->assertTrue($result);
    }

    /**
     * Test valid url passes with true
     *
     * @return void
     */
    public function test_invalid_url_throws_exception()
    {
        $action = $this->app->make(CheckURLIsValidAction::class);

        $this->expectException(InvalidURLException::class);

        $action->execute('hxxps://google.com/');
    }
}
