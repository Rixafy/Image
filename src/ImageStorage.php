<?php

declare(strict_types=1);

namespace Rixafy\Image;

use Nette\Utils\ImageException;
use Nette\Utils\UnknownImageFileException;
use Rixafy\Image\Exception\ImageNotFoundException;
use Rixafy\Image\Exception\ImageSaveException;
use Nette\Utils\Image as NetteImage;

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
     * @param string $tmpPath
     * @param Image $image
     * @param int $resizeType
     * @param null $width
     * @param null $height
     * @param null $fileType
     * @return NetteImage
     * @throws ImageException
     */
    public function saveTemp(string $tmpPath, Image $image, int $resizeType = NetteImage::EXACT, $width = null, $height = null, $fileType = null): NetteImage
    {
        try {
            $renderImage = NetteImage::fromFile($image->getRealPath());
            $renderImage->resize($width, $height, $resizeType);
            $renderImage->save($tmpPath, NetteImage::PNG ? 1 : 100, $fileType);

        } catch (UnknownImageFileException | ImageException $e) {
            $renderImage = NetteImage::fromBlank(200, 200, NetteImage::rgb(16, 16, 16));
            $renderImage->save($tmpPath);

        } finally {
            return $renderImage;
        }
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