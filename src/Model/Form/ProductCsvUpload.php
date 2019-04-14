<?php

namespace App\Model\Form;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ProductCsvUpload
 * @package App\Model\Form
 */
class ProductCsvUpload
{
    /**
     * @var UploadedFile
     *
     * @Assert\File(
     *     mimeTypes = {"text/csv", "text/plain"},
     *     mimeTypesMessage = "form.type_csv_error"
     * )
     */
    public $file;

    /**
     * @var boolean
     */
    public $overwrite = false;

    /**
     * @return UploadedFile
     */
    public function getFile(): ?UploadedFile
    {
        return $this->file;
    }

    /**
     * @param UploadedFile $file
     *
     * @return ProductCsvUpload
     */
    public function setFile(UploadedFile $file): ProductCsvUpload
    {
        $this->file = $file;

        return $this;
    }

    /**
     * @return bool
     */
    public function isOverwrite(): bool
    {
        return $this->overwrite;
    }

    /**
     * @param bool $overwrite
     *
     * @return ProductCsvUpload
     */
    public function setOverwrite(bool $overwrite): ProductCsvUpload
    {
        $this->overwrite = $overwrite;

        return $this;
    }
}