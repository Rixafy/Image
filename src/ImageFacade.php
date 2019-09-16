<?php

declare(strict_types=1);

namespace Rixafy\Image;

use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;
use Rixafy\Image\Exception\ImageNotFoundException;

class ImageFacade extends ImageRepository
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var ImageFactory */
    private $imageFactory;

    /** @var ImageConfig */
    private $imageConfig;

    public function __construct(
		EntityManagerInterface $entityManager,
		ImageFactory $imageFactory,
		ImageConfig $imageConfig
	) {
    	parent::__construct($entityManager);
        $this->entityManager = $entityManager;
        $this->imageFactory = $imageFactory;
		$this->imageConfig = $imageConfig;
	}

    public function create(ImageData $imageData, callable $saveFunction): Image
    {
        $image = $this->imageFactory->create($imageData);

        $saveFunction($this->imageConfig->getSavePath($image));

        $this->entityManager->persist($image);
        $this->entityManager->flush();

        return $image;
    }

	/**
	 * @throws ImageNotFoundException
	 */
    public function edit(UuidInterface $id, ImageData $imageData): Image
    {
        $image = $this->get($id);

        $image->edit($imageData);
        $this->entityManager->flush();

        return $image;
    }

    /**
     * @throws Exception\ImageNotFoundException
     */
    public function remove(UuidInterface $id): void
    {
        $image = $this->get($id);

		@unlink($image->getPath());

        $this->entityManager->remove($image);

        $this->entityManager->flush();
    }
}
