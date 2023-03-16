<?php
namespace App\Services\Production;

use App\Services\FileServiceInterface;

class FileServices implements FileServiceInterface
{
    protected $FileServiceRepository;

    public function upload($categoryType, $path, $dataFile)
    {
        switch ($categoryType) {
            case 'image':
                return $this->uploadImage($path, $dataFile); break;

            default:
                return null;
        }
    }

    public function uploadImage($path, $dataFile)
    {
        $pathFullName = $dataFile->store($path, 'public');

        return $pathFullName;
    }
}
