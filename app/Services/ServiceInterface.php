<?php
namespace App\Services;
interface ServiceInterface{
    public function upload($path);
    public function download($path);
    public function remove($path);
}
