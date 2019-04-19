<?php

declare(strict_types=1);

namespace Rixafy\Image;

class ImageFactory
{
    public function create(ImageData $imageData): Image
    {
        return new Image($imageData);
    }
}
