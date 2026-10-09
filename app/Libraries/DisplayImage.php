<?php

namespace App\Libraries;

use CodeIgniter\HTTP\Files\UploadedFile;
use RuntimeException;

class DisplayImage
{
    public static function store(UploadedFile $file, string $folder, int $width, int $height): string
    {
        $publicPath = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . $folder;
        $temporaryPath = WRITEPATH . 'uploads';

        if (! is_dir($publicPath) && ! mkdir($publicPath, 0755, true) && ! is_dir($publicPath)) {
            throw new RuntimeException('The public upload folder could not be created.');
        }
        if (! is_dir($temporaryPath) && ! mkdir($temporaryPath, 0755, true) && ! is_dir($temporaryPath)) {
            throw new RuntimeException('The temporary upload folder could not be created.');
        }

        $filename = $file->getRandomName();
        $file->move($temporaryPath, $filename);
        $temporaryFile = $temporaryPath . DIRECTORY_SEPARATOR . $filename;

        service('image')
            ->withFile($temporaryFile)
            ->fit($width, $height, 'center')
            ->save($publicPath . DIRECTORY_SEPARATOR . $filename, 85);

        @unlink($temporaryFile);

        return $filename;
    }
}
