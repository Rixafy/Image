<?php

declare(strict_types=1);

namespace Rixafy\Image\LocaleImage;

use Rixafy\Doctrination\Language\Language;

class LocaleImageData
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
    public $fileExtension;

    /** @var string */
    public $file;

    /** @var Image */
    public $image;

    /** @var Language */
    public $language;
}