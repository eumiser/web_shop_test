<?php

namespace App\Service\File;

use Box\Spout\Common\Exception\IOException;
use Box\Spout\Common\Exception\UnsupportedTypeException;
use Box\Spout\Common\Type;
use Box\Spout\Reader\CSV\Reader;
use Box\Spout\Reader\Exception\ReaderNotOpenedException;
use Box\Spout\Reader\ReaderFactory;

/**
 * Class SheetService
 * @package App\Service\File
 */
class SheetService
{
    /**
     * @param      $typeFile
     * @param      $filename
     * @param bool $headerKeys
     * @param bool $forceEncoding
     *
     * @return array
     * @throws IOException
     * @throws UnsupportedTypeException
     * @throws ReaderNotOpenedException
     */
    public static function readExcelFile($typeFile, $filename, $headerKeys = true, $forceEncoding = false): array
    {
        switch ($typeFile) {
            case Type::XLSX:
                $reader = ReaderFactory::create(Type::XLSX);
                $reader->open($filename);
                break;
            case Type::CSV:
                /** @var Reader $reader */
                $reader = ReaderFactory::create(Type::CSV);
                $reader->setFieldDelimiter(';');
                $reader->setEncoding('UTF-8');
                $reader->open($filename);
                break;
            default:
                $reader = null;
                break;
        }

        $excelData = array();
        /**
         * Read de csv file and order the content into de array $excelData
         */
        foreach ($reader->getSheetIterator() as $sheet) {
            $rowCount = 0;
            $columnHeaders = array();

            foreach ($sheet->getRowIterator() as $sheetRow) {
                if ($headerKeys) {
                    if ($rowCount === 0) {
                        if ($forceEncoding) {
                            $columnHeaders = array_map('utf8_encode', $sheetRow);
                        } else {
                            $columnHeaders = $sheetRow;
                        }
                    } else {
                        $rowData = array();
                        $lineRow = $rowCount + 1;

                        for ($i = 0, $headersCount = count($columnHeaders); $i < $headersCount; $i++) {
                            try {
                                $sheetRow[$i] = (isset($sheetRow[$i])) ? $sheetRow[$i] : '';

                                if ($forceEncoding) {
                                    $rowData[$columnHeaders[$i]] = utf8_encode(trim($sheetRow[$i]));
                                } else {
                                    $rowData[$columnHeaders[$i]] = trim($sheetRow[$i]);
                                }
                            } catch (\Exception $ex) {
                                echo 'Error en Columna ' . $columnHeaders[$i] . ' en la fila ' . $lineRow . ' con valor del tipo ' . gettype($sheetRow[$i]);
                                die();
                            }
                        }

                        $rowData['line_row'] = $lineRow;
                        $excelData[] = $rowData;
                    }
                    $rowCount++;
                } else {
                    $excelData[] = $sheetRow;
                }
            }
            /**
             * Read first sheet only
             */
            break;
        }

        $reader->close();

        return array_filter($excelData);
    }
}