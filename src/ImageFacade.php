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

    public function __construct(
        EntityManagerInterface $entityManager,
        ImageFactory $imageFactory
    ) {
    	parent::__construct($entityManager);
        $this->entityManager = $entityManager;
        $this->imageFactory = $imageFactory;
    }

    public function create(ImageData $imageData): Image
    {
        $image = $this->imageFactory->create($imageData);

        //todo: save on disk

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
        $entity = $this->get($id);

		//todo: remove from disk

        $this->entityManager->remove($entity);

        $this->entityManager->flush();
    }
}
