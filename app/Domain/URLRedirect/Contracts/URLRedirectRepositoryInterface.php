<?php

namespace App\Domain\URLRedirect\Contracts;

use App\Domain\URLRedirect\URLRedirect;
use App\Support\Repository\Contracts\RepositoryInterface;

interface URLRedirectRepositoryInterface extends RepositoryInterface
{
    /**
     * Get a unique token
     *
     * @return string Unique token
     *
     * @throws Exception
     */
    public function getUniqueToken(): string;

    /**
     * Find an entry by its token
     *
     * @param string $token Token value
     *
     * @return URLRedirect URL redirect
     *
     * @throws URLNotFoundException 
     */
    public function findByToken(string $token): URLRedirect;
}
