<?php

namespace App\Domain\BackupArchive;

use App\Http\Controllers\Controller;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BackupArchiveController extends Controller
{
    /**
     * Download the latest backup archive
     *
     * @param FilesystemAdapter $disk Disk
     *
     * @return StreamedResponse CSV download
     */
    public function getLatest(
    ): \Symfony\Component\HttpFoundation\StreamedResponse {
        return Storage::download('backup/latest.csv');
    }
}
