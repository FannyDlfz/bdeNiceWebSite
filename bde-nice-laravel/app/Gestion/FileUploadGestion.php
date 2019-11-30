<?php


namespace App\Gestion;


use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\File\File;

abstract class FileUploadGestion
{
    static function uploadFile(File $file, $name, $directory)
    {
        $fileName = $name.'.'. $file->getClientOriginalExtension();
        $file->move(public_path($directory), $fileName);

        return $fileName;
    }
}
