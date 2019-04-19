<?php

declare(strict_types=1);

namespace Rixafy\Image\LocaleImage;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Ramsey\Uuid\UuidInterface;
use Rixafy\Image\LocaleImage\Exception\LocaleImageNotFoundException;

class LocaleImageRepository
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
        return $this->entityManager->getRepository(LocaleImage::class);
    }

    /**
     * @throws LocaleImageNotFoundException
     */
    public function getByUrlName(string $urlName): LocaleImage
    {
        /** @var LocaleImage $localeImage */
        $localeImage = $this->getRepository()->findOneBy([
            'url_name' => $urlName
        ]);

        if ($localeImage === null) {
            throw new LocaleImageNotFoundException('LocaleImage with url ' . $urlName . ' not found.');
        }

        return $localeImage;
    }

    /**
     * @throws LocaleImageNotFoundException
     */
    public function get(UuidInterface $id): LocaleImage
    {
        /** @var LocaleImage $localeImage */
        $localeImage = $this->getRepository()->findOneBy([
            'id' => $id
        ]);

        if ($localeImage === null) {
            throw new LocaleImageNotFoundException('LocaleImage with id ' . $id . ' not found.');
        }

        return $localeImage;
    }

    public function getQueryBuilderForAll(): QueryBuilder
    {
        return $this->getRepository()->createQueryBuilder('l')
            ->orderBy('l.created_at');
    }
}
