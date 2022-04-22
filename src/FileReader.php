<?php

/**
 * PHP version 7
 *
 * @category Class
 * @package  RepositoryExplorer
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 */

namespace RepositoryExplorer;

use RepositoryExplorer\Interfaces\FileReaderInterface;
use RepositoryExplorer\Util\FileSystemException;

/**
 * FileReader : Implementa los metodos para el acceso al FileSystem
 *              Lectura y validación de archivo.
 *
 * @category Class
 * @package  RepositoryExplorer
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 */
class FileReader implements FileReaderInterface
{
    private static string $fileName;

    /**
     * Method __construct
     *
     * @param string $fileName src/Path al archivo
     *
     * @return void
     */
    public function __construct(string $fileName)
    {
            self::$fileName = $fileName;
    }

    /**
     * Method getFileName
     *
     * @return string
     */
    public function getFileName(): string
    {
            return self::$fileName;
    }

    /**
     * Method canReadFile Valida si $fileName es archivo y tiene permisos de lectura
     *
     * @return bool
     */
    public function canReadFile(): bool
    {
        if (is_file(self::$fileName) && is_readable(self::$fileName)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Method readFile Lee y retorna el contenido del archivo $fileName
     *
     * @return string
     */
    public function readFile(): string
    {
        try {
            if ($this->canReadFile()) {
                $contentFile = file_get_contents(self::$fileName);
                return ($contentFile === '' || !$contentFile) ? '' : $contentFile;
            } else {
                throw new FileSystemException(
                    "Error Lectura Archivo :" . self::$fileName
                );
            }
        } catch (FileSystemException $e) {
            $e->fsError();
            die("FileReader ERROR" . PHP_EOL);
        }
    }
}
