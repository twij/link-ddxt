<?php

namespace App\Domain\BackupArchive\Jobs;

use App\Domain\BackupArchive\BackupArchive;
use App\Domain\URLRedirect\Criteria\ArchivableURLRedirectsCriteria;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DailyBackupArchiveJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Creates a daily backup
     *
     * @param BackupArchive  $backup_archive  Backup archiver
     * @param Carbon         $carbon          Carbon; date/time
     *
     * @return bool Status
     */
    public function handle(
        BackupArchive $backup_archive,
        Carbon $carbon
    ): bool {
        $filename = 'backup/' . $carbon->now()->toDateString() . '.csv';
        $backup_archive->generate('local', $filename, [
            ArchivableURLRedirectsCriteria::class
        ]);
        $backup_archive->copy('backup/latest.csv');
        return true;
    }
}
