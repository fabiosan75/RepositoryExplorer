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

use RepositoryExplorer\Util\ComposerException;
use RepositoryExplorer\Interfaces\ComposerReaderInterface;
use RepositoryExplorer\Interfaces\FileReaderInterface;
use RepositoryExplorer\Interfaces\JsonDecoderInterface;

/**
 * Class ComposerReader Implementa los metodos necesarios para leer elementos de
 *                      archivos composer.json y obtener propiedades de su SCHEMA 
 *
 * @category Class
 * @package  RepositoryExplorer
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 */

class ComposerReader implements ComposerReaderInterface
{

    private $_dataSchema = [];
    public $jsonDecoder;

    public $config = [];
   
     
    /**
     * Method __construct
     *
     * @param FileReaderInterface $reader 
     *
     * @return void
     */
    public function __construct(FileReaderInterface $reader)
    { 
        $jsonDecoder = new JsonDecoder($reader);
        $this->loadConfig($jsonDecoder);
    }
 
     
    /**
     * Method loadConfig Mueve las propiedas del SCHEMA composer.json
     *                   a $config complementando la clase composer
     *                   con los atributos/propiedades del SCHEMA
     *
     * @param JsonDecoderInterface $jsonDecoder 
     * 
     * @return void
     */
    public function loadConfig(JsonDecoderInterface $jsonDecoder)
    {
        $this->_dataSchema = $jsonDecoder->loadSchema();
      
        try {
            if (!empty($this->_dataSchema)) {
                foreach ( $this->_dataSchema as $key => $value) {
                    $this->config[$key] = $value;
                }

            } else {
                throw new ComposerException(
                    " SCHEMA Vacio :"
                    .$jsonDecoder->fileReader->getFileName()
                );
            }
        } catch (ComposerException $e) {  
            echo $e->jsonError();
            die();
        }
    }
    
    /**
     * Method getSchema Retorna el array con el SCHEMA completo del composer.json
     *
     * @return array
     */
    public  function getSchema(): array 
    {
        return $this->_dataSchema;
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
                throw new ComposerException(
                    "NE Propiedad '{$propertyName}' en SCHEMA "
                );
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
     * @return bool
     */
    public function hasAttribute($attrName):bool
    {
        return isset($this->config[$attrName]);
    }

    /**
     * Method getAttribute Devuelve un atributo del SCHEMA 
     *
     * @param $attrName Nombre del Atributo/propiedad del SCHEMA
     *
     * @return string
     */
    public function getAttribute($attrName):string
    {

        try {
            if ($this->hasAttribute($attrName)) {
                return $this->config[$attrName];
            } else {
                throw new ComposerException("NE Propiedad '{$attrName}' en SCHEMA ");
            }

        } catch (ComposerException $e) {  
            echo $e->jsonError();  
            die();
        }

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
        $attrValue = [];
        if (array_key_exists($attrName, $this->config) 
            && is_array($this->config["$attrName"])
            && count($this->config["$attrName"])
        ) {

            $attrValue = $this->config["$attrName"]; 
        }

        return $attrValue;

    }

    /*  
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
    

    */
}
?>