<?php

declare(strict_types=1);

namespace Rixafy\Image;

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
     * @param string $id
     * @return string
     * @throws ImageSaveException
     */
    public function save($file, string $id): string
    {
        $extension = strtolower(pathinfo(basename($file["name"]),PATHINFO_EXTENSION));
        $target = $this->imageConfig->getSavePath() . $id . '.' . $extension;
        $moveResult = move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $this->imageConfig->getSavePath() . $id . '.' . $extension);

        if (!$moveResult) {
            throw new ImageSaveException('Image could not be saved.');
        }

        return $target;
    }
}