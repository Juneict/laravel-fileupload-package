<?php

return [
    // The disk on which to store uploaded files
    'disk' => 'public',

    // The default directory to store uploaded files
    'directory' => 'uploads',

    // Default validations for single file upload
    'single_file_validations' => [
        'required',
        'file',
        'max:2048', // 2MB max size
    ],

    // Default validations for multiple file upload
    'multiple_files_validations' => [
        'required',
        'array',
        'max:5', // Maximum 5 files
    ],

    // Default validations for each file in multiple upload
    'multiple_file_validations' => [
        'file',
        'max:2048', // 2MB max size per file
    ],
];