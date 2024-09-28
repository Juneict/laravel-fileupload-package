
# Laravel File Upload Package

#### Description
Laravel file upload is a package that allows to you upload a single file or multiple files simply.

#### Installation
```bach
composer require file-upload-package/laravel-file-upload
```
#### Publish Config File
```bach
php artisan vendor:publish --tag=config
```

### 1- Using the Package in Your Application

Here are a few short examples of what you can do:

```php
$post = new Post();
//...
$post->image =  FileUpload::uploadSingle($request->file('image'));

$post->save();
```
You can add folder path.
```php
$post = new Post();
//...
$post->image =  FileUpload::uploadSingle($request->file('iamge'),'posts');

$post->save();

***Dont forget*** run this command.
```bach
php artisan storage:link
```
****

### 2- MediaUploadService class
```php
$post = new Post();
//...
$post->files =  FileUpload::uploadMultiple($request->file('files'));

$post->save();
```

### 3- Old File Delete
```php
$fileUpload->oldFileDelete($oldFilePath);
```
