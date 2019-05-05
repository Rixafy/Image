<?php

declare(strict_types=1);

namespace Rixafy\Image\LocaleImage;

use Doctrine\ORM\EntityManagerInterface;
use Nette\Utils\ImageException;
use Ramsey\Uuid\UuidInterface;
use Rixafy\Image\Exception\ImageNotFoundException;
use Rixafy\Image\Exception\ImageSaveException;
use Rixafy\Image\ImageData;
use Rixafy\Image\ImageInterface;
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
     * @throws ImageSaveException
     */
    public function create(ImageData $imageData): LocaleImage
    {
        $localeImage = $this->localeImageFactory->create($imageData);

        $this->imageStorage->save($imageData->file['tmp_name'], (string) $localeImage->getId());

        $this->entityManager->persist($localeImage);
        $this->entityManager->flush();

        return $localeImage;
    }

    /**
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
     * @throws LocaleImageNotFoundException
     */
    public function get(UuidInterface $id): LocaleImage
    {
        return $this->localeImageRepository->get($id);
    }

	/**
	 * Permanent, removes localeImage from database and disk
	 *
	 * @throws ImageNotFoundException
	 * @throws LocaleImageNotFoundException
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
     * @throws Exception\LocaleImageNotFoundException
     * @throws ImageException
     */
    public function render(UuidInterface $id, int $width = null, int $height = null, $resizeType = NetteImage::EXACT): void
    {
        $entity = $this->get($id);

        $this->imageRenderer->render($id, $entity, $width, $height, $resizeType);
    }

    /**
     * Creates a temporary image file, render is not possible without existing file, this should happen in a template
     *
     * @throws ImageException
     * @throws LocaleImageNotFoundException
     */
    public function generate(UuidInterface $id, int $width = null, int $height = null, $resizeType = NetteImage::EXACT): string
    {
        $entity = $this->get($id);

        return $this->imageRenderer->generate($id, $entity, $width, $height, $resizeType);
    }
}