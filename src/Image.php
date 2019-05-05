<?php

declare(strict_types=1);

namespace Rixafy\Image;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Rixafy\DoctrineTraits\DateTimeTrait;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="image")
 */
class Image implements ImageInterface
{
	/**
	 * @var UuidInterface
	 * @ORM\Id
	 * @ORM\Column(type="uuid_binary", unique=true)
	 */
	protected $id;

    use DateTimeTrait;
    use ImagePropertiesTrait;
    use ImageMetaTrait;

    public function __construct(UuidInterface $id, ImageData $imageData)
    {
    	$this->id = $id;
        $this->image_group = $imageData->imageGroup;

		[$this->width, $this->height] = getimagesize($imageData->file['tmp_name']);
		$this->file_extension = pathinfo($imageData->file['tmp_name'], PATHINFO_EXTENSION);

		$this->edit($imageData);
    }

    public function edit(ImageData $imageData): void
    {
        $this->alternative_text = $imageData->alternativeText;
        $this->title = $imageData->title;
        $this->description = $imageData->description;
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
        $data->alternativeText = $this->alternative_text;

        return $data;
    }
}
