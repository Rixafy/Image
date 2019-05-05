<?php

declare(strict_types=1);

namespace Rixafy\Image\LocaleImage;

use Ramsey\Uuid\Uuid;
use Rixafy\Image\ImageData;

class LocaleImageFactory
{
    public function create(ImageData $imageData): LocaleImage
    {
        return new LocaleImage(Uuid::uuid4(), $imageData);
    }
}
