<?php

declare(strict_types=1);

namespace Rixafy\Image\Group;

use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;

class ImageGroupFacade
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var ImageGroupRepository */
    private $imageGroupRepository;

    /** @var ImageGroupFactory */
    private $imageGroupFactory;

    public function __construct(
        EntityManagerInterface $entityManager,
        ImageGroupRepository $imageGroupRepository,
        ImageGroupFactory $imageGroupFactory
    ) {
        $this->entityManager = $entityManager;
        $this->imageGroupRepository = $imageGroupRepository;
        $this->imageGroupFactory = $imageGroupFactory;
    }

    /**
     * @param ImageGroupData $imageGroupData
     * @return ImageGroup
     */
    public function create(ImageGroupData $imageGroupData): ImageGroup
    {
        $imageGroup = $this->imageGroupFactory->create($imageGroupData);
        
        $this->entityManager->persist($imageGroup);
        $this->entityManager->flush();

        return $imageGroup;
    }

    /**
     * @param UuidInterface $id
     * @param ImageGroupData $imageGroupData
     * @return ImageGroup
     * @throws Exception\ImageGroupNotFoundException
     */
    public function edit(UuidInterface $id, ImageGroupData $imageGroupData): ImageGroup
    {
        $imageGroup = $this->imageGroupRepository->get($id);
        $imageGroup->edit($imageGroupData);

        $this->entityManager->flush();

        return $imageGroup;
    }

    /**
     * @param UuidInterface $id
     * @return ImageGroup
     * @throws Exception\ImageGroupNotFoundException
     */
    public function get(UuidInterface $id): ImageGroup
    {
        return $this->imageGroupRepository->get($id);
    }

    /**
     * Permanent removal
     *
     * @param UuidInterface $id
     * @throws Exception\ImageGroupNotFoundException
     */
    public function remove(UuidInterface $id): void
    {
        $entity = $this->get($id);

        $this->entityManager->remove($entity);

        $this->entityManager->flush();
    }

}