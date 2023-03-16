<?php
namespace App\Services;

interface FileServiceInterface
{
    /**
     * upload file with option.
     *
     * @param string $categoryType
     * @param string $path
     * @param File   $dataFile
     *
     * @return string
     */
    public function upload($categoryType, $path, $dataFile);

    public function uploadImage($path, $dataFile);
}
