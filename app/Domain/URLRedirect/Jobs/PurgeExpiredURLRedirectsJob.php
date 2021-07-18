<?php

namespace App\Domain\URLRedirect\Jobs;

use App\Domain\URLRedirect\Contracts\URLRedirectRepositoryInterface;
use App\Domain\URLRedirect\Criteria\ExpiredURLRedirectsCriteria;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\InvalidCastException;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use InvalidArgumentException;

class PurgeExpiredURLRedirectsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
        $expired = $redirect_repository->pushCriteria(new ExpiredURLRedirectsCriteria)->all();
        foreach($expired as $entry) {
            try {
                $redirect_repository->delete($entry->id);
            } catch (\Exception $exception) {
                print 'Unable to delete URL redirect: ' . $exception->getMessage();
            }
        }
    }
}
