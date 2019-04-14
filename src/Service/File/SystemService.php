<?php

namespace App\Service\File;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class SystemService
 * @package App\Service
 */
class SystemService
{
    /** @var Filesystem */
    private $filesystem;

    /** @var TranslatorInterface */
    private $translator;

    /**
     * LocalFileSystem constructor.
     *
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->filesystem = new Filesystem();
        $this->translator = $translator;
    }

    /**
     * @param string $path
     *
     * @return array
     * @throws \Exception
     */
    public function getFilesInPath(string $path): array
    {
        if (!$this->filesystem->exists($path)) {
            throw new \Exception(
                "{$this->translator->trans('error.directory_not_found')} $path."
            );
        }

        /** @var SplFileInfo[] $finder */
        $finder = Finder::create()->in($path)->files()->sortByName();
        $listNamesFiles = array();
        foreach ($finder as $file) {
            $listNamesFiles[] = $file;
        }

        return $listNamesFiles;
    }

    /**
     * @param string $path
     *
     * @return array
     * @throws \Exception
     */
    public function getFilesInPathIndexedByName(string $path): array
    {
        if (!$this->filesystem->exists($path)) {
            throw new \Exception(
                "{$this->translator->trans('error.file_not_found_in')} $path."
            );
        }

        /** @var SplFileInfo[] $finder */
        $finder = Finder::create()->in($path)->files()->sortByName();
        $listNamesFiles = array();
        foreach ($finder as $file) {
            $filename = $file->getBasename('.' . $file->getExtension());
            $listNamesFiles[$filename][] = $file;
        }

        return $listNamesFiles;
    }

    /**
     * @param string $path
     *
     * @return bool
     * @throws \Exception
     */
    public function createPathIfNotExist(string $path): bool
    {
        if ($this->filesystem->exists($path)) {
            return true;
        }

        try {
            $this->filesystem->mkdir($path);
        } catch (\Exception $exception) {
            throw new \Exception(
                "file.exception.can_not_create_file $path. Exception: {$exception->getMessage()}"
            );
        }

        $this->changeDirPermissions($path);

        return true;
    }

    /**
     * @param string $filename
     *
     * @return bool
     */
    public function fileExist(string $filename): bool
    {
        return $this->filesystem->exists($filename);
    }

    /**
     * @param string $pathname
     *
     * @return bool
     */
    public function pathExist(string $pathname): bool
    {
        return $this->filesystem->exists($pathname);
    }

    /**
     * @param string $filename
     *
     * @return bool|string
     * @throws \Exception
     */
    public function getFileContents(string $filename)
    {
        $fileContent = file_get_contents($filename);
        if (!$fileContent) {
            throw new \Exception("Error en el fichero $filename");
        }

        return $fileContent;
    }

    /**
     * @param $filename
     *
     * @return \SimpleXMLElement
     * @throws \Exception
     */
    public function loadSimpleXmlFile($filename): \SimpleXMLElement
    {
        if (!$this->fileExist($filename)) {
            throw new \Exception("No se ha encontrado el archivo $filename");
        }

        return simplexml_load_string(file_get_contents($filename));
    }

    /**
     * @param string $dirname
     * @param int    $permissions
     *
     * @throws \Exception
     *
     * Lectura y escritura para el propietario, nada para los demás: 600
     * Lectura y escritura para el propietario, lectura para los demás: 644
     * Todos para el propietario, lectura y ejecución para el grupo del propietario: 750
     * Todos para el propietario, lectura y ejecución para los otros: 755
     */
    public function changeDirPermissions(string $dirname, $permissions = 0777): void
    {
        try {
            $this->filesystem->chmod($dirname, $permissions, 0000, true);
        } catch (\Exception $e) {
            throw new \Exception(
                "Error al cambiar los permisos de $dirname a $permissions. Exception: {$e->getMessage()}"
            );
        }
    }
}