<?php

namespace App\Domain\URLRedirect\Actions;

use App\Domain\URLRedirect\URLRedirect;
use Carbon\Carbon;

class CheckURLRedirectDeletedAction
{
    protected Carbon $carbon;

    /**
     * Checks whether a URL Redirect has been deleted
     *
     * @param Carbon $carbon Carbon; date/time
     */
    public function __construct(Carbon $carbon) {
        $this->carbon = $carbon;
    }

    /**
     * Execute the action
     *
     * @param URLRedirect $redirect URL Redirect to test
     *
     * @return bool Deleted status
     */
    public function execute(URLRedirect $redirect)
    {
        if ($redirect->delete_at  && 
            $redirect->delete_at <= $this->carbon->now() ||
            $redirect->deleted_at
        ) {
            return true;
        }

        return false;
    }
}
