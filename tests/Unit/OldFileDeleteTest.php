<?php

namespace FileUploadPackage\FileUpload\Tests\Unit;

use Illuminate\Support\Facades\Storage;
use FileUploadPackage\FileUpload\Tests\TestCase;
use FileUploadPackage\FileUpload\Facades\FileUpload;

class OldFileDeleteTest extends TestCase
{
    public function testOldFileDelete()
    {
        Storage::fake('local');

        $filePath = 'uploads/old-file.jpg';
        Storage::disk('local')->put($filePath, 'dummy content');

        Storage::disk('local')->assertExists($filePath);

        $fileUpload = new FileUpload();
        $fileUpload->oldFileDelete($filePath);

        Storage::disk('local')->assertMissing($filePath);
    }
}