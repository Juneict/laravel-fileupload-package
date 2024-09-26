<?php

namespace FileUploadPackage\FileUpload\Tests\Unit;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use FileUploadPackage\FileUpload\FileUpload;
use FileUploadPackage\FileUpload\Tests\TestCase;

class MultipleFileUploadTest extends TestCase
{
    public function testMultipleFileUpload()
    {
        Storage::fake('local');

        $files = [
            UploadedFile::fake()->image('test1.jpg'),
            UploadedFile::fake()->image('test2.png'),
            UploadedFile::fake()->image('test3.gif')
        ];

        $fileUpload = new FileUpload();
        $paths = $fileUpload->uploadMultiple($files);

        $this->assertCount(3, $paths);

        foreach ($paths as $path) {
            Storage::disk('local')->assertExists($path);
        }
    }

    public function testMultipleFileUploadValidation()
    {
        $this->expectException(\InvalidArgumentException::class);

        $files = [
            UploadedFile::fake()->create('document1.pdf', 2000, 'application/pdf'),
            UploadedFile::fake()->create('document2.pdf', 2000, 'application/pdf'),
            UploadedFile::fake()->create('document3.pdf', 2000, 'application/pdf')
        ];

        $fileUpload = new FileUpload();
        $fileUpload->uploadMultiple($files, 'uploads', ['mimes:jpg,png', 'max:1000']);
    }

    public function testMultipleFileUploadMaxFiles()
    {
        $this->expectException(\InvalidArgumentException::class);

        $files = [
            UploadedFile::fake()->image('test1.jpg'),
            UploadedFile::fake()->image('test2.jpg'),
            UploadedFile::fake()->image('test3.jpg'),
            UploadedFile::fake()->image('test4.jpg'),
            UploadedFile::fake()->image('test5.jpg'),
            UploadedFile::fake()->image('test6.jpg') // Assuming max is 5
        ];

        $fileUpload = new FileUpload();
        $fileUpload->uploadMultiple($files, 'uploads', ['array', 'max:5']);
    }

    public function testMultipleFileUploadCustomDirectory()
    {
        Storage::fake('local');

        $files = [
            UploadedFile::fake()->image('test1.jpg'),
            UploadedFile::fake()->image('test2.png')
        ];

        $customDirectory = 'custom/directory';

        $fileUpload = new FileUpload();
        $paths = $fileUpload->uploadMultiple($files, $customDirectory);

        $this->assertCount(2, $paths);

        foreach ($paths as $path) {
            $this->assertStringStartsWith($customDirectory, $path);
            Storage::disk('local')->assertExists($path);
        }
    }
}