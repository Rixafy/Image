<?php

declare(strict_types=1);

namespace Rixafy\Image\LocaleImage;

use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;
use Rixafy\Image\ImageData;
use Rixafy\Image\ImageRenderer;
use Rixafy\Image\ImageStorage;
use Rixafy\Image\LocaleImage\Exception\LocaleImageNotFoundException;
use Nette\Utils\Image as NetteImage;

class LocaleImageFacade
{
    /** @var ImageStorage */
    private $imageStorage;

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var LocaleImageRepository */
    private $localeImageRepository;

    /** @var ImageRenderer */
    private $imageRenderer;

    /** @var LocaleImageFactory */
    private $localeImageFactory;

    /**
     * LocaleImageFacade constructor.
     * @param ImageStorage $imageStorage
     * @param EntityManagerInterface $entityManager
     * @param LocaleImageRepository $localeImageRepository
     * @param ImageRenderer $imageRenderer
     * @param LocaleImageFactory $localeImageFactory
     */
    public function __construct(
        ImageStorage $imageStorage,
        EntityManagerInterface $entityManager,
        LocaleImageRepository $localeImageRepository,
        ImageRenderer $imageRenderer,
        LocaleImageFactory $localeImageFactory
    ) {
        $this->imageStorage = $imageStorage;
        $this->entityManager = $entityManager;
        $this->localeImageRepository = $localeImageRepository;
        $this->imageRenderer = $imageRenderer;
        $this->localeImageFactory = $localeImageFactory;
    }

    /**
     * @param ImageData $imageData
     * @return LocaleImage
     * @throws \Rixafy\Image\Exception\ImageSaveException
     */
    public function create(ImageData $imageData): LocaleImage
    {
        $localeImage = $this->localeImageFactory->create($imageData);

        $this->imageStorage->save($imageData->file, (string) $localeImage->getId());

        $this->entityManager->persist($localeImage);
        $this->entityManager->flush();

        return $localeImage;
    }

    /**
     * @param UuidInterface $id
     * @param ImageData $imageData
     * @return LocaleImage
     * @throws LocaleImageNotFoundException
     */
    public function edit(UuidInterface $id, ImageData $imageData): LocaleImage
    {
        $localeImage = $this->localeImageRepository->get($id);
        $localeImage->edit($imageData);

        $this->entityManager->flush();

        return $localeImage;
    }

    /**
     * @param UuidInterface $id
     * @return LocaleImage
     * @throws LocaleImageNotFoundException
     */
    public function get(UuidInterface $id): LocaleImage
    {
        return $this->localeImageRepository->get($id);
    }

    /**
     * Permanent, removes localeImage from database and disk
     *
     * @param UuidInterface $id
     * @throws LocaleImageNotFoundException
     * @throws \Rixafy\Image\Exception\ImageNotFoundException
     */
    public function remove(UuidInterface $id): void
    {
        $entity = $this->get($id);

        $this->imageStorage->remove($entity->getRealPath());
        $this->entityManager->remove($entity);

        $this->entityManager->flush();
    }


    /**
     * @param UuidInterface $id
     * @param int|null $width
     * @param int|null $height
     * @param int $resizeType
     * @throws Exception\LocaleImageNotFoundException
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
}