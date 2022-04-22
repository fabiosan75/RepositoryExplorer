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
use RepositoryExplorer\Interfaces\JsonDecoderInterface;
use RepositoryExplorer\Util\ComposerException;

/**
 * Class JsonDecoder : Implementa los metodos para el acceso al FileSystem
 *
 * @category Class
 * @package  RepositoryExplorer
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 */

class JsonDecoder implements JsonDecoderInterface
{
    public FileReaderInterface $fileReader;

    private string $jsonSchema;

    /**
     * Method __construct
     *
     * @param FileReaderInterface $reader Instancia para acceso al .json
     *
     * @return void
     */
    public function __construct(FileReaderInterface $reader)
    {
        $this->fileReader = $reader;
    }

    /**
     * getReader
     *
     * @return FileReaderInterface
     */
    public function getReader(): FileReaderInterface
    {
        return $this->fileReader;
    }

    /**
     * Method loadSchema Lee el contenido del archivo instanciado en $fileReader
     *                   valida que sea un json bien "formado" y retorna un array
     *                   con el SCHEMA
     *
     * @return array<string, array<string, string>|string>
     */
    public function loadSchema(): array
    {
        $dataSchema = [];

        $this->jsonSchema = $this->fileReader->readfile();

        try {
            if ($this->validateJsonFormat()) {
                $dataSchema = json_decode($this->jsonSchema, true);
            } else {
                throw new ComposerException(
                    "Formato Json Invalido "
                    . $this->fileReader->getFileName()
                );
            }
        } catch (ComposerException $e) {
                $e->jsonError();
        }

        return $dataSchema;
    }

    /**
     * Method getSchema
     *
     * @return string
     */
    public function getSchema(): string
    {
        return $this->jsonSchema;
    }

    /**
     * Method validateJsonFormat
     * Valida que el formato del SCHEMA sea un JSON "bien" formado
     *
     * @return bool
     */
    public function validateJsonFormat(): bool
    {

        if (!empty($this->jsonSchema)) {
            @json_decode($this->jsonSchema);
            return (json_last_error() === JSON_ERROR_NONE);
        }

        return false;
    }
}
