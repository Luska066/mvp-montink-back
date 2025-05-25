<?php

namespace App\Service;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
class FileStore
{

    static function store(string $directory, UploadedFile $file, $filename)
    {
        return Storage::disk(ENV('FILESYSTEM_DISK'))->putFileAs($directory,$file,$filename);
    }

    static function delete(string $path)
    {
        return Storage::disk(ENV('FILESYSTEM_DISK'))->delete($path);
    }

    static function getUrl(string $path){
        return Storage::disk(ENV('FILESYSTEM_DISK'))->url($path);
    }

    static function getPath(string $path){
        return Storage::disk(ENV('FILESYSTEM_DISK'))->path($path);
    }

}
