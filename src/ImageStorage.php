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
     * @throws ImageSaveException
     */
    public function save(ImageInterface $image, string $tmpName, string $fileName): string
    {
        $target = $this->imageConfig->getSavePath() . '/' . $fileName . '.' . $image->getFileExtension();
        $moveResult = move_uploaded_file($tmpName, $target);

        if (!$moveResult) {
            throw new ImageSaveException('Image could not be saved.');
        }

        return $target;
    }

    /**
     * @throws ImageException
     */
    public function saveTemp(string $tempPath, ImageInterface $image, int $width = null, int $height = null, $resizeType = NetteImage::EXACT): NetteImage
    {
        $extensions = array_flip(self::FORMATS) + ['jpg' => NetteImage::JPEG];
        $format = isset($extensions[$imageData->fileFormat]) ? $extensions[$image->getFileFormat()] : self::FORMATS['webp'];

        try {
            $renderImage = NetteImage::fromFile($image->getRealPath());
            if ($width !== null || $height !== null) {
                $renderImage->resize($width, $height, $resizeType);
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
     * @throws ImageNotFoundException
     */
    public function remove(string $path): void
    {
        if (!@unlink($path)) {
           throw new ImageNotFoundException('Path "' . $path . '" is invalid, image cannot be removed.');
        }
    }
}
