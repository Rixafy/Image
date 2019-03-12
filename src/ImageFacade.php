<?php

declare(strict_types=1);

namespace Rixafy\Image;

use Doctrine\ORM\EntityManagerInterface;

class ImageFacade
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var ImageRepository */
    private $imageRepository;

    /** @var ImageFactory */
    private $imageFactory;

    /**
     * ImageFacade constructor.
     * @param EntityManagerInterface $entityManager
     * @param ImageRepository $imageRepository
     * @param ImageFactory $imageFactory
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ImageRepository $imageRepository,
        ImageFactory $imageFactory
    ) {
        $this->entityManager = $entityManager;
        $this->imageRepository = $imageRepository;
        $this->imageFactory = $imageFactory;
    }

    /**
     * @param ImageData $imageData
     * @return Image
     */
    public function create(ImageData $imageData): Image
    {
        $image = $this->imageFactory->create($imageData);

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
}