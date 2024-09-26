<?php

namespace FileUploadPackage\FileUpload;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
}