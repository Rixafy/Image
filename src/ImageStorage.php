<?php

declare(strict_types=1);

namespace Rixafy\Image;

use Rixafy\Image\Exception\ImageNotFoundException;
use Rixafy\Image\Exception\ImageSaveException;

class ImageStorage
{
    /** @var ImageConfig */
    private $imageConfig;

    public function __construct(ImageConfig $imageConfig)
    {
        $this->imageConfig = $imageConfig;
    }

    /**
     * @param $file
     * @param string $fileName
     * @return string Real path of image
     * @throws ImageSaveException
     */
    public function save($file, string $fileName): string
    {
        $extension = strtolower(pathinfo(basename($file["name"]),PATHINFO_EXTENSION));
        $target = $this->imageConfig->getSavePath() . $fileName . '.' . $extension;
        $moveResult = move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $this->imageConfig->getSavePath() . $fileName . '.' . $extension);

        if (!$moveResult) {
            throw new ImageSaveException('Image could not be saved.');
        }

        return $target;
    }

    /**
     * @param string $path
     * @throws ImageNotFoundException
     */
    public function remove(string $path): void
    {
        if (!@unlink($path)) {
           throw new ImageNotFoundException('Path "' . $path . '" is invalid, image cannot be removed.');
        }
    }
}