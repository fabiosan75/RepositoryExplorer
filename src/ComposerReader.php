<?php

namespace GetTreeRepository;

use GetTreeRepository\ComposerException;
//use GetTreeRepository\Interfaces\FileReaderInterface;
use GetTreeRepository\Interfaces\JsonDecoderInterface;

/**
 * Template File Doc Comment
 *
 * PHP version 7
 *
 * @category Class
 * @package  GetTreeRepository
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 */

/**
 * Template Class Doc Comment
 *
 * ComposerReader Class
 * ComposerReader : Implementa los metodos necesarios para leer elementos de
 * archivos composer.json y obtener propiedades de su SCHEMA 
 *
 * @category Class
 * @package  GetTreeRepository
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 */
class ComposerReader
{

    private iterable $_dataSchema = [];
    public $jsonDecoder;

    public $config = [];
   
    /**
     * Method __construct
     *
     * @param $file Ruta al archivo [path/composer.json] a procesar
     *
     * @return void
     */
    public function __construct(string $file)
    { 
        $this->file = $file;
        $reader = new FileReader($file);
        $jsonDecoder = new JsonDecoder($reader);
      //  $this->_dataSchema = $jsonDecoder->loadSchema($this->file);
        $this->loadConfig($jsonDecoder);
    }
 
    /**
     * Method getPropertySchema
     *
     * @param string $propertyName Nombre de la propiedad o grupo 
     *                             de elementos a extraer
     *
     * @return array
     */
    public function getPropertySchema(string $propertyName)
    {
       
        try {
            if (isset($this->_dataSchema[$propertyName])) {
                return $this->_dataSchema[$propertyName];
            } else {
                throw new ComposerException("NE Propiedad '{$propertyName}' en SCHEMA ");
            }

        } catch (ComposerException $e) {  
            echo $e->jsonError();  
            die();
        }
    }
    
    /**
     * Method loadConfig Mueve las propiedas del SCHEMA composer.json
     *                   a $config complementando la clase composer
     *                   con los atributos/propiedades del SCHEMA
     *
     * @return void
     */
    public function loadConfig(JsonDecoderInterface $jsonDecoder)
    {
        $this->_dataSchema = $jsonDecoder->loadSchema($this->file);
      
        // $this->loadConfig();

        try {
            if (!empty($this->_dataSchema)) {
                foreach ( $this->_dataSchema as $key => $value) {
                    $this->config[$key] = $value;
                }

            } else {
                throw new ComposerException(" SCHEMA Vacio :".$this->file);
            }
        } catch (ComposerException $e) {  
            echo $e->jsonError();
            die();
        }
    }
    
    /**
     * Method hasAttribute  Verifica si Atributo/propiedad existe 
     *                      en el composer->config Ej : name/version/require
     *
     * @param $attrName Nombre del Atributo/propiedad 
     *
     * @return void
     */
    public function hasAttribute($attrName):bool
    {
        return isset($this->config[$attrName]);
    }

    /**
     * Method getAttribute
     *
     * @param $attrName $attrName [explicite description]
     *
     * @return void
     */
    public function getAttribute($attrName)
    {
        if (! $this->hasAttribute($attrName)) {
            throw new \InvalidArgumentException(sprintf('The attribute "%s" does not exist.', $key));
        }

        return $this->config[$attrName];
    }

    /**
     * Method getAttrArray Extrae del SCHEMA una propiedad de tipo array
     *                      Ej : require, repositories 
     * 
     * @param string $attrName Nombre de la propiedad o atributo del SCHEMA
     *
     * @return array
     */
    public function getAttrArray(string $attrName): array
    {

        if (array_key_exists($attrName, $this->config) 
            && is_array($this->config["$attrName"])
            && count($this->config["$attrName"])
        ) {

            return $this->config["$attrName"]; 
        }

        return [];

    }

    public function checkPkgName(string $pkgName): bool
    {

        if (empty($pkgName)) {
            return false;
        }
        $pkgNameString = $this->getPropertySchema('name');

        if (empty($pkgNameString) || ($pkgNameString != $pkgName)) {
            return false;
        }
    }

    public function getTreePkgSchema(string $masterRepository)
    {
        $treeRepositoryArray = array();

        $requireArray = $this->getPropertySchema('require');

        $pkgNameString = $this->getPropertySchema('name');

        $pkgTypeString = $this->getPropertySchema('type');

        if (count($requireArray) != 0) {

            foreach ($requireArray as $pkgNameString => $pkgVersionString) {

                list($vendorNameString,$projectNameString) = array_pad(explode('/', $pkgNameString), 2, null);
            
                if ($masterRepository === $vendorNameString) {
                    $treeRepositoryArray[$projectNameString] = array(
                        "type" => $pkgTypeString,
                        "name" => $vendorNameString,
                        "version" => $pkgVersionString);
                }
            }
        }
        return $treeRepositoryArray;

    } // End method getTreePkgSchema

}
?>