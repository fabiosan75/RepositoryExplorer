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
 * Interface ComposerReaderInterface : Define los metodos para el acceso a las 
 *                                     propiedades de un json SCHEMA
 * 
 * @category Interface
 * @package  GetTreeRepository
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 */

interface ComposerReaderInterface
{
    
    /**
     * Method getPropertySchema
     *
     * @param string $propertyName [explicite description]
     *
     * @return void
     */
    public function getPropertySchema(string $propertyName);
    
    /**
     * Method loadConfig
     *
     * @param JsonDecoderInterface $jsonDecoder [explicite description]
     *
     * @return void
     */
    public function loadConfig(JsonDecoderInterface $jsonDecoder);
    
    /**
     * Method hasAttribute
     *
     * @param $attrName $attrName [explicite description]
     *
     * @return bool
     */
    public function hasAttribute($attrName):bool;
    
    /**
     * Method getAttribute
     *
     * @param $attrName $attrName [explicite description]
     *
     * @return void
     */
    public function getAttribute($attrName);
    
    /**
     * Method getAttrArray
     *
     * @param string $attrName [explicite description]
     *
     * @return array
     */
    public function getAttrArray(string $attrName): array;

    //  public function checkPkgName(string $pkgName): bool;


}
