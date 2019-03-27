<?php

declare(strict_types=1);

namespace Rixafy\Image;

use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;
use Nette\Utils\Image as NetteImage;

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
     * @param UuidInterface $id
     * @param ImageData $imageData
     * @return Image
     * @throws Exception\ImageNotFoundException
     */
    public function edit(UuidInterface $id, ImageData $imageData): Image
    {
        $image = $this->imageRepository->get($id);
        $image->edit($imageData);

        $this->entityManager->flush();

        return $image;
    }

    /**
     * @param UuidInterface $id
     * @return Image
     * @throws Exception\ImageNotFoundException
     */
    public function get(UuidInterface $id): Image
    {
        return $this->imageRepository->get($id);
    }

    /**
     * Permanent, removes image from database and disk
     *
     * @param UuidInterface $id
     * @throws Exception\ImageNotFoundException
     */
    public function remove(UuidInterface $id): void
    {
        $entity = $this->get($id);

        $this->imageStorage->remove($entity->getRealPath());
        $this->entityManager->remove($entity);

        $this->entityManager->flush();
    }

    /**
     * Returns image response to browser, image must be firstly generated
     *
     * @param UuidInterface $id
     * @param int|null $width
     * @param int|null $height
     * @param int $resizeType
     * @throws Exception\ImageNotFoundException
     * @throws \Nette\Utils\ImageException
     */
    public function render(UuidInterface $id, int $width = null, int $height = null, $resizeType = NetteImage::EXACT): void
    {
        $entity = $this->get($id);

        $imageData = $entity->getData();
        $imageData->width = $width == null ? $entity->getWidth() : $width;
        $imageData->height = $width == null ? $entity->getHeight() : $height;

        $this->imageRenderer->render($id, $imageData, $resizeType);
    }

    /**
     * Creates a temporary image file, render is not possible without existing file, this should happen in a template
     *
     * @param UuidInterface $id
     * @param int|null $width
     * @param int|null $height
     * @param int $resizeType
     * @return string
     * @throws Exception\ImageNotFoundException
     * @throws \Nette\Utils\ImageException
     */
    public function generate(UuidInterface $id, int $width = null, int $height = null, $resizeType = NetteImage::EXACT): string
    {
        $entity = $this->get($id);

        $imageData = $entity->getData();
        $imageData->width = $width == null ? $entity->getWidth() : $width;
        $imageData->height = $width == null ? $entity->getHeight() : $height;

        return $this->imageRenderer->generate($id, $imageData, $resizeType);
    }
}