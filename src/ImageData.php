<?php

declare(strict_types=1);

namespace Rixafy\Image;

use Rixafy\Image\Group\ImageGroup;
use Rixafy\Language\Language;

class ImageData
{
    /** @var string */
    public $description;

    /** @var string */
    public $title;

    /** @var string */
    public $alternativeText;

    /** @var string */
    public $fileFormat;

    /** @var array */
    public $file;

    /** @var ImageGroup */
    public $imageGroup;

    /** @var Language */
    public $language;
}
