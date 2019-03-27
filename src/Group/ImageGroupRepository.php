<?php

declare(strict_types=1);

namespace Rixafy\Image\ImageGroup;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Rixafy\Image\ImageGroup\Exception\ImageGroupNotFoundException;

class ImageGroupRepository
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return EntityRepository|\Doctrine\Common\Persistence\ObjectRepository
     */
    protected function getRepository()
    {
        return $this->entityManager->getRepository(ImageGroup::class);
    }

    /**
     * @param string $name
     * @return ImageGroup
     * @throws ImageGroupNotFoundException
     */
    public function getByName(string $name): ImageGroup
    {
        /** @var ImageGroup $imageGroup */
        $imageGroup = $this->getRepository()->findOneBy([
            'name' => $name
        ]);

        if ($imageGroup === null) {
            throw new ImageGroupNotFoundException('ImageGroup with name ' . $name . ' not found.');
        }

        return $imageGroup;
    }

    /**
     * @param UuidInterface $id
     * @return ImageGroup
     * @throws ImageGroupNotFoundException
     */
    public function get(UuidInterface $id): ImageGroup
    {
        /** @var ImageGroup $image */
        $image = $this->getRepository()->findOneBy([
            'id' => $id
        ]);

        if ($image === null) {
            throw new ImageGroupNotFoundException('Image with id ' . $id . ' not found.');
        }

        return $image;
    }

    public function getQueryBuilderForAll(): QueryBuilder
    {
        return $this->getRepository()->createQueryBuilder('i')
            ->orderBy('i.created_at');
    }
}