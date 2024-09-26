<?php

namespace FileUploadPackage\FileUpload\Tests;

use FileUploadPackage\FileUpload\FileUploadServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            FileUploadServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('file-upload', [
            'disk' => 'local',
            'directory' => 'uploads',
            'single_file_validations' => [
                'required',
                'file',
                'max:2048',
            ],
            'multiple_files_validations' => [
                'required',
                'array',
                'max:5',
            ],
            'multiple_file_validations' => [
                'file',
                'max:2048',
            ],
        ]);
    }
}