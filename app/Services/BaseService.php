<?php

namespace App\Services;

use Illuminate\Support\Facades\App;

use Illuminate\Support\Facades\Storage;

abstract class BaseService implements ServiceInterface
{

    private $disk;
    protected $path;

    public function __construct()
    {
        if (App::environment(['local'])) {
            $this->disk = 'local';
        } else {
            $this->disk = 'S3';
        }
    }

    /* Get path */
    public function getPath()
    {
        return $this->path;
    }
    /* Set path */
    public function setPath($path)
    {
        if ($path) {
            $this->path = $path;
        }
    }
    public function upload($file)
    {
        $filePath = '';
        if ($file) {
            $filePath = Storage::disk($this->disk)->putFile($this->path, $file);
        }
        return $filePath;
    }

    public function download($file, $name = 'download')
    {
        $headers = ['Content-Type: application/php'];
        if ($file && Storage::disk($this->disk)->exists($file)) {
            return Storage::download($file, $name, $headers);
        }
        return false;
    }

    public function remove($file)
    {
        if ($file && Storage::disk($this->disk)->exists($file)) {
            return Storage::disk($this->disk)->delete($file);
        }
        return false;
    }
}
