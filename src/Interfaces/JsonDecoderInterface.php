<?php
/**
 * ComposerReaderInterface
 *
 * PHP version 7
 *
 * @category Interface
 * @package  GetTreeRepository
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 */

namespace GetTreeRepository\Interfaces;

/**
 * Class JsonDecoder : Implementa los metodos para el acceso al FileSystem
 * 
 * @category Class
 * @package  GetTreeRepository
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 */
interface JsonDecoderInterface
{

    /**
     * Method getSchema
     *
     * @return string
     */
    public function getSchema(): string;
    
    /**
     * Method loadSchema Lee el contenido del archivo instanciado en $fileReader
     *                   valida que sea un json bien "formado" y retorna un array
     *                   con el SCHEMA
     * 
     * @return array
     */
    public function loadSchema(): array;
    
    /**
     * Method validateJsonFormat
     * Valida que el formato del SCHEMA sea un JSON "bien" formado
     * 
     * @return bool
     */
    public function validateJsonFormat(): bool;
    
}
