<?php

declare(strict_types=1);

namespace Rixafy\Image;

use Rixafy\Image\Group\ImageGroup;
use Rixafy\Language\Language;

class ImageData
{
    /** @var string */
    public $urlName;

    /** @var string */
    public $description;

    /** @var string */
    public $title;

    /** @var string */
    public $alternativeText;

    /** @var int */
    public $width;

    /** @var int */
    public $height;

    /** @var string */
    public $realPath;

    /** @var string */
    public $fileFormat;

    /** @var string */
    public $file;

    /** @var ImageGroup */
    public $imageGroup;

    /** @var Language */
    public $language;
}