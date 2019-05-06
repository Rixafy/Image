<?php

declare(strict_types=1);

namespace Rixafy\Image;

interface ImageInterface
{
	public function getWidth(): int;

	public function getHeight(): int;

	public function getFileFormat(): string;

	public function getFileExtension(): string;

	public function getRealPath(): string;
}
