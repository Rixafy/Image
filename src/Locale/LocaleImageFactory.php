<?php

declare(strict_types=1);

namespace Rixafy\Image\LocaleImage;

class LocaleImageFactory
{
    public function create(LocaleImageData $imageData): LocaleImage
    {
        return new LocaleImage($imageData);
    }
}