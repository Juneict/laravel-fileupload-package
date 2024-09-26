<?php

namespace FileUploadPackage\FileUpload\Tests\Unit;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use FileUploadPackage\FileUpload\FileUpload;
use FileUploadPackage\FileUpload\Tests\TestCase;

class SingleFileUploadTest extends TestCase
{
    public function testSingleFileUpload()
    {
        Storage::fake('local');

        $file = UploadedFile::fake()->image('test.jpg');

        $fileUpload = new FileUpload();
        $path = $fileUpload->uploadSingle($file);

        Storage::disk('local')->assertExists($path);
    }

    public function testSingleFileUploadValidation()
    {
        $this->expectException(\InvalidArgumentException::class);

        $file = UploadedFile::fake()->create('document.pdf', 2000, 'application/pdf');

        $fileUpload = new FileUpload();
        $fileUpload->uploadSingle($file, 'uploads', ['mimes:jpg,png', 'max:1000']);
    }
}