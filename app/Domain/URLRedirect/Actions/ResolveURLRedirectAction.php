<?php

namespace App\Domain\URLRedirect\Actions;

use App\Domain\URLRedirect\Contracts\URLRedirectRepositoryInterface;
use App\Domain\URLRedirect\Exceptions\URLDeletedException;
use App\Domain\URLRedirect\Exceptions\URLNotFoundException;
use App\Domain\URLRedirect\Jobs\HitURLRedirectJob;
use Illuminate\Log\Logger;

class ResolveURLRedirectAction
{
    /**
     * Logger
     *
     * @var Logger
     */
    protected Logger $logger;

    /**
     * URL Redirect repository
     *
     * @var URLRedirectRepositoryInterface
     */
    protected URLRedirectRepositoryInterface $redirect_repository;

    /**
     * Resolves a token string to its original URL
     *
     * @param Logger                          $logger                Logger
     * @param URLRedirectRepositoryInterface  $redirect_repository   URL Redirect repository
     */
    public function __construct(
        Logger $logger,
        URLRedirectRepositoryInterface $redirect_repository
    ) {
        $this->logger = $logger;
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
        try {
            $redirect = $this->redirect_repository->findURLByTokenCached($token);
        } catch (URLDeletedException $exception) {
            $this->logger->debug($exception->getMessage());
            abort(410);
        } catch (URLNotFoundException $exception) {
            $this->logger->debug($exception->getMessage());
            abort(404);
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage());
            abort(500);
        }

        HitURLRedirectJob::dispatch($token);

        return $redirect;
    }
}
