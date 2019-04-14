<?php

namespace App\Service\File;

use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class directoryService
 */
class DirectoryService
{
    public const PUBLIC_DIR = 'public';
    public const XML_FILES_DIR = 'XmlFiles';

    /** @var SystemService */
    private $fileSystemService;

    /** @var string */
    private $projectDir;

    /**
     * DirectoryService constructor.
     *
     * @param SystemService   $fileSystemService
     * @param KernelInterface $kernel
     */
    public function __construct(SystemService $fileSystemService, KernelInterface $kernel)
    {
        $this->fileSystemService = $fileSystemService;
        $this->projectDir = $kernel->getProjectDir();
    }

    /**
     * @return string
     */
    public function getProjectDir(): string
    {
        return $this->projectDir;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getPublicDir(): string
    {
        $path = $this->projectDir . DIRECTORY_SEPARATOR . self::PUBLIC_DIR;

        $this->fileSystemService->createPathIfNotExist($path);

        return $path;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getXmlFilesDir(): string
    {
        $path = $this->getPublicDir() . DIRECTORY_SEPARATOR . self::XML_FILES_DIR;

        $this->fileSystemService->createPathIfNotExist($path);

        return $path;
    }
}