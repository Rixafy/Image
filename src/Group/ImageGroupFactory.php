<?php

declare(strict_types=1);

namespace Rixafy\Image\Group;

class ImageGroupFactory
{
    public function create(ImageGroupData $imageGroupData)
    {
        return new ImageGroup($imageGroupData);
    }
}