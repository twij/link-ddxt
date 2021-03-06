<?php

namespace App\Domain\URLRedirect\Jobs;

use App\Domain\URLRedirect\Contracts\URLRedirectRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\InvalidCastException;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use InvalidArgumentException;

class HitURLRedirectJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string URL redirect token
     */
    protected string $redirect_token;

    /**
     * Increments the hit counter for a redirect
     *
     * @param string $redirect_token URL redirect token
     */
    public function __construct(string $redirect_token)
    {
        $this->redirect_token = $redirect_token;
    }

    /**
     * Handle the job
     * 
     * @param URLRedirectRepositoryInterface $redirect_repository URL Redirect repository
     *
     * @return void
     *
     * @throws InvalidArgumentException 
     * @throws InvalidCastException 
     */
    public function handle(
        URLRedirectRepositoryInterface $redirect_repository
    ) {
        try {
            $url_redirect = $redirect_repository->findByToken($this->redirect_token);
            $url_redirect->hits++;
            $url_redirect->save();
        } catch (\Exception $exception) {
            print 'Hit counter not updated: ' . $exception->getMessage();
        }
    }
}
