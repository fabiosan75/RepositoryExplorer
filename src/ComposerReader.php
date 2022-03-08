<?php

namespace GetTreeRepository;

require_once __DIR__.'/../vendor/autoload.php';

use GetTreeRepository\FileReader;
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
 *
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
 *
 */


class ComposerReader
{

    private iterable $_dataSchema = [];
  //  public $jsonDecoder;

    public $config = [];
   
    /**
     * Method __construct
     *
     * @param $file $file Ruta al archivo [path/composer.json] a procesar
     *
     * @return void
     */
    public function __construct(JsonDecoderInterface $jsonDecoder)
    { 
       // $this->jsonDecoder = $jsonDecoder;
        $this->_dataSchema = $jsonDecoder->loadSchema();
      //  $this->_dataSchema = $this->jsonDecoder->decodeSchema();   
        $this->loadConfig();
    }
 
    /**
     * Method getPropertySchema
     *
     * @param string $propertyName nombre de la propiedad o grupo de elementos a extraer
     *
     * @return array
     */
    public function getPropertySchema(string $propertyName)
    {
        if (isset($this->_dataSchema[$propertyName])) {
            return $this->_dataSchema[$propertyName];
        } else {
            throw new \UnexpectedValueException("NE Propiedad {$propertyName} en SCHEMA ");
        }
    }

    public function loadConfig()
    {
        if (!empty($this->_dataSchema)) {
            foreach ( $this->_dataSchema as $key => $value) {
                $this->config[$key] = $value;
            }

        } else {
            throw new \UnexpectedValueException("SCHEMA Vacio");
        }
    }
    
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

$file = $argv[1];//'../../Proyecto1/composer.json';
//$file = '../../../libreria1/composer.json';

$masterRepository = 'fabiosan75'; // Vendor Name directorio que contiene el repositorio

//$composerMeta = array();

$reader = new FileReader($file);

$decoder = new JsonDecoder($file, $reader);

$composerReader = new ComposerReader($decoder);

$dependency = $composerReader->getAttrArray('require');
$dependency = $composerReader->getAttrArray('repositories');

var_dump($dependency);

$masterRepository = 'fabiosan75';
$treePkgArray = $composerReader->getTreePkgSchema($masterRepository);

print_r($treePkgArray);


?>