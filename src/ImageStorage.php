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
    private const FORMATS = [NetteImage::JPEG => 'jpeg', NetteImage::PNG => 'png', NetteImage::GIF => 'gif', NetteImage::WEBP => 'webp'];

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
     * @param string $tempPath
     * @param ImageData $imageData
     * @param int $resizeType
     * @return NetteImage
     * @throws ImageException
     */
    public function saveTemp(string $tempPath, ImageData $imageData, $resizeType = NetteImage::EXACT): NetteImage
    {
        $extensions = array_flip(self::FORMATS) + ['jpg' => NetteImage::JPEG];
        $format = isset($extensions[$imageData->fileFormat]) ? $extensions[$imageData->fileFormat] : self::FORMATS['webp'];

        try {
            $renderImage = NetteImage::fromFile($imageData->realPath);
            if ($imageData->width !== null || $imageData->height !== null) {
                $renderImage->resize($imageData->width, $imageData->height, $resizeType);
            }
            $renderImage->save($tempPath, NetteImage::PNG ? 1 : 100, $format);

        } catch (UnknownImageFileException | ImageException $e) {
            $renderImage = NetteImage::fromBlank(200, 200, NetteImage::rgb(16, 16, 16));
            $renderImage->save($tempPath);

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