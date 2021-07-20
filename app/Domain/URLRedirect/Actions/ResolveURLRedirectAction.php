<?php

namespace App\Domain\URLRedirect\Actions;

use App\Domain\URLRedirect\Contracts\URLRedirectRepositoryInterface;
use App\Domain\URLRedirect\Jobs\HitURLRedirectJob;

class ResolveURLRedirectAction
{
    /**
     * @var URLRedirectRepositoryInterface URL Redirect repository
     */
    protected URLRedirectRepositoryInterface $redirect_repository;

    /**
     * Resolves a token string to its original URL
     *
     * @param URLRedirectRepositoryInterface $redirect_repository URL Redirect repository
     */
    public function __construct(
        URLRedirectRepositoryInterface $redirect_repository
    ) {
        $this->redirect_repository = $redirect_repository;
    }

    /**
     * Execute the action
     *
     * @param string $token Token value
     *
     * @return string Original URL
     */
    public function execute(string $token): string
    {
        $redirect = $this->redirect_repository->findURLByTokenCached($token);

        HitURLRedirectJob::dispatch($token);

        return $redirect;
    }
}
