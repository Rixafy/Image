<?php

declare(strict_types=1);

namespace Rixafy\Image\LocaleImage;

use Rixafy\Translation\Annotation\Translatable;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Rixafy\Image\ImageInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Rixafy\DoctrineTraits\ActiveTrait;
use Rixafy\DoctrineTraits\DateTimeTrait;
use Rixafy\Image\ImageData;
use Rixafy\Image\ImagePropertiesTrait;
use Rixafy\Translation\EntityTranslator;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="locale_image")
 */
class LocaleImage extends EntityTranslator implements ImageInterface
{
    use ActiveTrait;
    use DateTimeTrait;
    use ImagePropertiesTrait;

	/**
	 * @var UuidInterface
	 * @ORM\Id
	 * @ORM\Column(type="uuid_binary", unique=true)
	 */
	protected $id;

    /**
     * @Translatable
     * @var string
     */
    private $urlName;

    /**
     * @Translatable
     * @var string
     */
    private $description;

    /**
     * @Translatable
     * @var string
     */
    private $title;

    /**
     * @Translatable
     * @var string
     */
    private $alternativeText;

    /**
     * One LocaleImage has Many Translations
     *
     * @ORM\OneToMany(targetEntity="\Rixafy\Image\LocaleImage\LocaleImageTranslation", mappedBy="entity", cascade={"persist", "remove"})
     * @var LocaleImageTranslation[]
     */
    protected $translations;

    public function __construct(UuidInterface $id, ImageData $imageData)
    {
    	$this->id = $id;
        $this->imageGroup = $imageData->imageGroup;
        $this->translations = new ArrayCollection();

		[$this->width, $this->height] = getimagesize($imageData->file['tmp_name']);
		$this->fileExtension = pathinfo($imageData->file['name'], PATHINFO_EXTENSION);

		$this->edit($imageData);
    }

    public function edit(ImageData $imageData): void
    {
        $this->editTranslation($imageData);
    }

    public function getId(): UuidInterface
	{
		return $this->id;
	}

    public function getData(): ImageData
    {
        $data = new ImageData();

        $data->description = $this->description;
        $data->title = $this->title;
        $data->alternativeText = $this->alternativeText;
        $data->language = $this->translationLanguage;

        return $data;
    }

    public function getUrlName(): string
    {
        return $this->urlName;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getAlternativeText(): string
    {
        return $this->alternativeText;
    }

    public function getTranslations()
    {
        return $this->translations;
    }
}
