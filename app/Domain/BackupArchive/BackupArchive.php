<?php

namespace App\Domain\BackupArchive;

use App\Domain\URLRedirect\Contracts\URLRedirectRepositoryInterface;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Filesystem\FilesystemAdapter;
use League\Flysystem\FileExistsException;
use League\Flysystem\FileNotFoundException;

class BackupArchive
{
    /**
     * @var URLRedirectRepositoryInterface Redirect repository
     */
    protected URLRedirectRepositoryInterface $redirect_repository;

    /**
     * @var FilesystemManager File system
     */
    protected FilesystemManager $filesystem;

    /**
     * @var FilesystemAdapter Disk adapter
     */
    protected FilesystemAdapter $disk;

    /**
     * @var array Criteria to apply
     */
    protected array $criteria;

    /**
     * @var string Filename to save
     */
    protected string $filename;

    /**
     * @var string 
     */
    protected string $backup_archive;

    /**
     * Creates a CSV backup of live URL redirects
     *
     * @param FilesystemManager               $filesystem           File system
     * @param URLRedirectRepositoryInterface  $redirect_repository  Redirect repository
     */
    public function __construct(
        FilesystemManager $filesystem,
        URLRedirectRepositoryInterface $redirect_repository
    ) {
        $this->filesystem = $filesystem;
        $this->redirect_repository = $redirect_repository;
    }

    /**
     * Generate and store the CSV
     *
     * @param string  $disk      Disk to use
     * @param string  $filename  Filename to save
     * @param array   $criteria  Criteria to apply
     *
     * @return bool Status
     */
    public function generate(
        string $disk = 'local',
        string $filename = 'backup/archive.csv',
        array $criteria = []
    ): bool {
        try {
            $this->disk = $this->filesystem->disk($disk);
            $this->filename = $filename;

            foreach ($criteria as $filter) {
                $this->redirect_repository->pushCriteria(new $filter());
            }
            $redirects = $this->redirect_repository->all();
    
            $file = fopen($this->disk->path($this->filename), 'w');
            fputcsv($file, ['Full URL', 'Destination URL', 'Created At']);
    
            foreach ($redirects as $redirect) {
                fputcsv($file, [
                    'Full URL' => $redirect->present()->localURL,
                    'Destination URL' => $redirect->url,
                    'Created At' => $redirect->created_at
                ]);
            }

            fclose($file);

            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * Copy the generated file (run generate first)
     *
     * @param string $destination Destination file
     *
     * @return bool Status or exception
     *
     * @throws FileExistsException 
     * @throws FileNotFoundException 
     */
    public function copy(string $destination)
    {
        if ($this->disk->exists($destination)) {
            $this->disk->delete($destination);
        }
        $this->disk->copy($this->filename, $destination);
        return true;
    }
}
