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

    public function uploadSingle(UploadedFile $file, string $directory = null, array $validations = [])
    {
        $directory = $directory ?? $this->config['directory'];
        $validations = $validations ?: $this->config['single_file_validations'];

        $this->validate([$file], $validations);

        return $file->store($directory, $this->config['disk']);
    }

    public function uploadMultiple(array $files, string $directory = null, array $validations = [])
    {
        $directory = $directory ?? $this->config['directory'];
        $validations = $validations ?: $this->config['multiple_files_validations'];

        $this->validate($files, $validations);

        $paths = [];
        foreach ($files as $file) {
            $paths[] = $file->store($directory, $this->config['disk']);
        }

        return $paths;
    }

    protected function validate(array $files, array $validations)
    {
        $validator = Validator::make(['files' => $files], [
            'files' => $validations,
            'files.*' => $this->config['multiple_file_validations']
        ]);

        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }
    }
}