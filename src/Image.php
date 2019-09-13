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
class Image
{
	/**
	 * @var UuidInterface
	 * @ORM\Id
	 * @ORM\Column(type="uuid_binary", unique=true)
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string", unique=true, length=255)
	 * @var string
	 */
	private $path;

	/**
	 * @ORM\Column(type="string", length=127, nullable=true)
	 * @var string
	 */
	private $caption;

	/**
	 * @ORM\Column(type="string", length=127, nullable=true)
	 * @var string
	 */
	private $alternativeText;

    use DateTimeTrait;

    public function __construct(UuidInterface $id, ImageData $imageData)
    {
    	$this->id = $id;
		$this->path = $imageData->path;
		$this->edit($imageData);
    }

    public function edit(ImageData $imageData): void
    {
        $this->alternativeText = $imageData->alternativeText;
        $this->caption = $imageData->caption;
    }

    public function getId(): UuidInterface
	{
		return $this->id;
	}

    public function getData(): ImageData
    {
        $data = new ImageData();
        $data->caption = $this->caption;
        $data->alternativeText = $this->alternativeText;

        return $data;
    }

	public function getPath(): string
	{
		return $this->path;
	}

	public function getCaption(): ?string
	{
		return $this->caption;
	}

	public function getAlternativeText(): ?string
	{
		return $this->alternativeText;
	}
}
