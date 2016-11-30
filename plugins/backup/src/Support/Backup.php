<?php namespace WebEd\Plugins\Backup\Support;

use Illuminate\Filesystem\Filesystem;
use PclZip as Zip;
use Carbon\Carbon;

class Backup
{
    /**
     * @var Filesystem
     */
    protected $file;

    /**
     * @var mixed
     */
    protected $folder;

    /**
     * @var string
     */
    protected $backupsFolder;

    /**
     * @var string
     */
    protected $backupName;

    /**
     * @var string
     */
    protected $timestamp;

    public function __construct()
    {
        $this->file = new Filesystem();

        $this->backupsFolder = storage_path('app/backups');

        if (!$this->file->isDirectory($this->backupsFolder)) {
            $this->file->makeDirectory($this->backupsFolder, 0777);
        }
    }

    /**
     * @return string
     */
    public function getTimestamp()
    {
        if(!$this->timestamp) {
            $this->timestamp = Carbon::now()->format('Y-m-d-h-i-s');
        }
        return $this->timestamp;
    }

    /**
     * Get all backups
     * @return array
     */
    public function all()
    {
        $backups = [];
        $files = $this->file->allFiles($this->backupsFolder);

        /**
         * Only get .zip files
         */
        foreach ($files as $key => $file) {
            /**
             * @var \SplFileInfo $file
             */
            if (substr($file, -4) == '.zip' && $this->file->exists($file)) {
                $backups[] = [
                    'file_path' => $file->getPathname(),
                    'file_name' => $file->getFilename(),
                    'file_size' => $file->getSize(),
                    'last_modified' => $this->file->lastModified($file),
                    'disk' => 'local',
                ];
            }
        }
        return $backups;
    }

    /**
     * @param $path
     * @return null|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($path)
    {
        if($this->file->exists($path)) {
            return response()->download($path);
        }
        return null;
    }

    /**
     * @param null $path
     * @return bool
     */
    public function delete($path = null)
    {
        if ($path === null) {
            $path = $this->backupsFolder;
            return $this->file->deleteDirectory($path);
        }

        if ($this->file->exists($path)) {
            $this->file->delete($path);
            return true;
        }
        return false;
    }

    /**
     * Delete backups folder
     */
    public function deleteFolderBackup()
    {
        $this->file->deleteDirectory(storage_path('app/backups'));
    }

    /**
     * @param $name
     */
    public function createBackupFolder($name)
    {
        $this->timestamp = $this->getTimestamp();
        $this->folder = $this->createFolder($this->backupsFolder . DIRECTORY_SEPARATOR . $this->timestamp);
        $this->backupName = $name;
    }

    /**
     * @param $folder
     * @return mixed
     * @author Sang Nguyen <sangnguyenplus@gmail.com>
     */
    public function createFolder($folder)
    {
        if (!$this->file->isDirectory($folder)) {
            $this->file->makeDirectory($folder);
            chmod($folder, 0777);
        }
        return $folder;
    }

    /**
     * @return bool
     * @author Sang Nguyen <sangnguyenplus@gmail.com>
     */
    public function backupDb()
    {
        try {
            $file = 'database-' . $this->backupName . '-' . $this->getTimestamp();
            $path = $this->folder . DIRECTORY_SEPARATOR . $file;

            $sql = env('DB_DUMP_PATH') . 'mysqldump -u' . env('DB_USERNAME') . ' -p' . env('DB_PASSWORD') . ' -h' . env('DB_HOST') . ' ' . env('DB_DATABASE') . ' > ' . $path . '.sql';

            system($sql);

            $this->compressDbToZip($path, $file);
            if (file_exists($path . '.zip')) {
                chmod($path . '.zip', 0777);
            }
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * @param $source
     * @return bool
     * @author Sang Nguyen <sangnguyenplus@gmail.com>
     */
    public function backupFolder($source)
    {
        $file = $this->folder . DIRECTORY_SEPARATOR . 'medias-' . $this->backupName . '-' . $this->getTimestamp() . '.zip';

        if (class_exists('ZipArchive', false)) {
            $zip = new \ZipArchive();
            // create and open the archive
            if ($zip->open($file, \ZipArchive::CREATE) !== true) {
                $this->file->delete($this->folder);
            }
        } else {
            $zip = new Zip($file);
        }
        $arr_src = explode(DIRECTORY_SEPARATOR, $source);
        $path_length = strlen(implode(DIRECTORY_SEPARATOR, $arr_src) . DIRECTORY_SEPARATOR);
        // add each file in the file list to the archive
        $this->recurseZip($source, $zip, $path_length);
        if (class_exists('ZipArchive', false)) {
            $zip->close();
        }
        if (file_exists($file)) {
            chmod($file, 0777);
        }
        return true;
    }

    /**
     * @param $path
     * @param $file
     * @return bool
     * @author Sang Nguyen <sangnguyenplus@gmail.com>
     */
    public function restoreDb($file, $path)
    {
        $this->restore($file, $path);
        $file = $path . DIRECTORY_SEPARATOR . \File::name($file) . '.sql';

        if (!file_exists($file)) {
            return false;
        }
        // Force the new login to be used
        \DB::purge();
        \DB::unprepared('USE `' . env('DB_DATABASE') . '`');
        \DB::connection()->setDatabaseName(env('DB_DATABASE'));
        \DB::unprepared(file_get_contents($file));

        $this->delete($file);
        return true;
    }

    /**
     * @param $fileName
     * @param $pathTo
     * @return bool
     * @author Sang Nguyen <sangnguyenplus@gmail.com>
     */
    public function restore($fileName, $pathTo)
    {
        if (class_exists('ZipArchive', false)) {
            $zip = new \ZipArchive;
            if ($zip->open($fileName) === true) {
                $zip->extractTo($pathTo);
                $zip->close();
                return true;
            }
        } else {
            $archive = new Zip($fileName);
            $archive->extract(PCLZIP_OPT_PATH, $pathTo, PCLZIP_OPT_REMOVE_ALL_PATH);
            return true;
        }

        return false;
    }

    /**
     * @param $src
     * @param $zip
     * @param $pathLength
     * @author Sang Nguyen <sangnguyenplus@gmail.com>
     */
    public function recurseZip($src, &$zip, $pathLength)
    {
        foreach (scan_folder($src) as $file) {
            if ($this->file->isDirectory($src . DIRECTORY_SEPARATOR . $file)) {
                $this->recurseZip($src . DIRECTORY_SEPARATOR . $file, $zip, $pathLength);
            } else {
                if (class_exists('ZipArchive', false)) {
                    $zip->addFile($src . DIRECTORY_SEPARATOR . $file, substr($src . DIRECTORY_SEPARATOR . $file, $pathLength));
                } else {
                    $zip->add($src . DIRECTORY_SEPARATOR . $file, PCLZIP_OPT_REMOVE_PATH, substr($src . DIRECTORY_SEPARATOR . $file, $pathLength));
                }
            }
        }
    }

    /**
     * @param $path
     * @param $name
     * @author Sang Nguyen <sangnguyenplus@gmail.com>
     */
    public function compressDbToZip($path, $name)
    {
        $filename = $path . '.zip';

        if (class_exists('ZipArchive', false)) {
            $zip = new \ZipArchive();
            if ($zip->open($filename, \ZipArchive::CREATE) == true) {
                $zip->addFile($path . '.sql', $name . '.sql');
                $zip->close();
            }
        } else {
            $archive = new Zip($filename);
            $archive->add($path . '.sql', PCLZIP_OPT_REMOVE_PATH, $filename);
        }
        $this->delete($path . '.sql');
    }
}
