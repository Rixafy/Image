<?php

declare(strict_types=1);

namespace Rixafy\Image\ImageGroup;

class ImageGroupFactory
{
    public function create(ImageGroupData $imageGroupData)
    {
        return new ImageGroup($imageGroupData);
    }
}