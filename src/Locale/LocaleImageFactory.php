<?php

declare(strict_types=1);

namespace Rixafy\Image\LocaleImage;

use Rixafy\Image\ImageData;

class LocaleImageFactory
{
    public function create(ImageData $imageData): LocaleImage
    {
        return new LocaleImage($imageData);
    }
}