<?php

namespace FileUploadPackage\FileUpload;

use Illuminate\Support\ServiceProvider;

class FileUploadServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/file-upload.php', 'file-upload'
        );

        $this->app->bind('file-upload', function ($app) {
            return new FileUpload();
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/file-upload.php' => config_path('file-upload.php'),
        ], 'config');
    }
}