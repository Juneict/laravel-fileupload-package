<?php

namespace FileUploadPackage\FileUpload;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUpload
{
    protected $config;

    public function __construct()
    {
        $this->config = config('file-upload');
    }

    public function uploadSingle(UploadedFile $file, string $directory = null)
    {
        $directory = $directory ?? $this->config['directory'];

        return $file->store($directory, $this->config['disk']);
    }

    public function uploadMultiple(array $files, string $directory = null)
    {
        $directory = $directory ?? $this->config['directory'];

        $paths = [];
        foreach ($files as $file) {
            $paths[] = $file->store($directory, $this->config['disk']);
        }

        return $paths;
    }

     /**
     * Delete the old file from storage.
     *
     * @param string $oldFilePath
     * @return bool
     */
    public function oldFileDelete(string $oldFilePath)
    {
        if (Storage::disk($this->config['disk'])->exists($oldFilePath)) {
            return Storage::disk($this->config['disk'])->delete($oldFilePath);
        }

        return false;
    }
}