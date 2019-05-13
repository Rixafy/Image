<?php

declare(strict_types=1);

namespace Rixafy\Image\Group;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Ramsey\Uuid\UuidInterface;
use Rixafy\Image\Group\Exception\ImageGroupNotFoundException;

class ImageGroupRepository
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return EntityRepository|ObjectRepository
     */
    protected function getRepository()
    {
        return $this->entityManager->getRepository(ImageGroup::class);
    }

	/**
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

    /**
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

    public function getQueryBuilderForAll(): QueryBuilder
    {
        return $this->getRepository()->createQueryBuilder('e')
            ->orderBy('e.created_at');
    }
}
