<?php

namespace App\Domain\URLRedirect\Actions;

use App\Domain\URLRedirect\Exceptions\InvalidURLException;
use Illuminate\Support\Facades\Http;

class CheckURLIsValidAction
{
    /**
     * Get request the URL to test it is valid
     *
     * @param string $url URL to test
     *
     * @return bool Status
     */
    public function execute(string $url): bool
    {
        try {
            Http::get($url)->throw();
            return true;
        } catch (\Exception $exception) {
            throw new InvalidURLException();
        }
    }
}
