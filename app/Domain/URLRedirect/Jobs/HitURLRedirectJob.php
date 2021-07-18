<?php

namespace App\Domain\URLRedirect\Jobs;

use App\Domain\URLRedirect\URLRedirect;
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
     * @var URLRedirect Entry
     */
    protected URLRedirect $redirect;

    /**
     * Increments the hit counter for a redirect
     *
     * @param URLRedirect $redirect Redirect entry
     */
    public function __construct(URLRedirect $redirect)
    {
        $this->redirect = $redirect;
    }

    /**
     * Handle the job
     *
     * @return void
     *
     * @throws InvalidArgumentException 
     * @throws InvalidCastException 
     */
    public function handle() {
        $this->redirect->hits++;
        $this->redirect->save();
    }
}