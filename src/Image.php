<?php

declare(strict_types=1);

namespace Rixafy\Image;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="image", indexes={
 * 		@ORM\Index(columns={"original_name"})
 *	 })
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
	 * @ORM\Column(type="string", length=63)
	 * @var string
	 */
	private $originalName;

	/**
	 * @ORM\Column(type="string", length=5)
	 * @var string
	 */
	private $extension;

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

	/**
	 * @ORM\Column(type="datetime")
	 * @var DateTime
	 */
	private $createdAt;

	/**
	 * @ORM\Column(type="datetime")
	 * @var DateTime
	 */
	private $updatedAt;

    public function __construct(UuidInterface $id, ImageData $imageData)
    {
    	$this->id = $id;
		$this->extension = pathinfo($imageData->originalName, PATHINFO_EXTENSION);
		$this->createdAt = new DateTime();
		$this->edit($imageData);
    }

    public function edit(ImageData $imageData): void
    {
        $this->alternativeText = $imageData->alternativeText;
        $this->caption = $imageData->caption;
        $this->originalName = $imageData->originalName;
        $this->updatedAt = new DateTime();
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

	public function onFileSave($path): void
	{
		$this->path = $path;
	}

	public function getCaption(): ?string
	{
		return $this->caption;
	}

	public function getAlternativeText(): ?string
	{
		return $this->alternativeText;
	}

	public function getOriginalName(): string
	{
		return $this->originalName;
	}

	public function getExtension(): string
	{
		return $this->extension;
	}

	public function getCreatedAt(): DateTime
	{
		return $this->createdAt;
	}

	public function getUpdatedAt(): DateTime
	{
		return $this->updatedAt;
	}
}
