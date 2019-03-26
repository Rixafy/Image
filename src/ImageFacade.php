<?php

declare(strict_types=1);

namespace Rixafy\Image;

use Doctrine\ORM\EntityManagerInterface;

class ImageFacade
{
    /** @var ImageStorage */
    private $imageStorage;

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var ImageRepository */
    private $imageRepository;

    /** @var ImageRenderer */
    private $imageRenderer;

    /** @var ImageFactory */
    private $imageFactory;

    /**
     * ImageFacade constructor.
     * @param ImageStorage $imageStorage
     * @param EntityManagerInterface $entityManager
     * @param ImageRepository $imageRepository
     * @param ImageRenderer $imageRenderer
     * @param ImageFactory $imageFactory
     */
    public function __construct(
        ImageStorage $imageStorage,
        EntityManagerInterface $entityManager,
        ImageRepository $imageRepository,
        ImageRenderer $imageRenderer,
        ImageFactory $imageFactory
    ) {
        $this->imageStorage = $imageStorage;
        $this->entityManager = $entityManager;
        $this->imageRepository = $imageRepository;
        $this->imageRenderer = $imageRenderer;
        $this->imageFactory = $imageFactory;
    }

    /**
     * @param ImageData $imageData
     * @return Image
     * @throws Exception\ImageSaveException
     */
    public function create(ImageData $imageData): Image
    {
        $image = $this->imageFactory->create($imageData);

        $this->imageStorage->save($imageData->file, (string) $image->getId());

        $this->entityManager->persist($image);
        $this->entityManager->flush();

        return $image;
    }

    /**
     * @param string $id
     * @param ImageData $imageData
     * @return Image
     * @throws Exception\ImageNotFoundException
     */
    public function edit(string $id, ImageData $imageData): Image
    {
        $image = $this->imageRepository->get($id);
        $image->edit($imageData);

        $this->entityManager->flush();

        return $image;
    }

    /**
     * @param string $id
     * @return Image
     * @throws Exception\ImageNotFoundException
     */
    public function get(string $id): Image
    {
        return $this->imageRepository->get($id);
    }

    /**
     * Permanent, removes image from database and disk
     *
     * @param string $id
     * @throws Exception\ImageNotFoundException
     */
    public function remove(string $id): void
    {
        $entity = $this->get($id);

        $this->imageStorage->remove($entity->getRealPath());
        $this->entityManager->remove($entity);

        $this->entityManager->flush();
    }
}