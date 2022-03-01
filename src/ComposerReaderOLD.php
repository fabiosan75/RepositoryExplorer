<?php

namespace RepositoryValidator;

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

    private string $fileName;
  //  private $composerSchema;
    private static string $_fileContent;
    
    private array $jsonSchema;
    
    /**
     * Method __construct
     *
     * @param $file $file Ruta al archivo [path/composer.json] a procesar
     *
     * @return void
     */
    public function __construct(string $file)
    {
        if(empty($file))
            throw new \Exception("ERROR Nombre File {$file}");
      
            $this->fileName = $file;
    }
    
    public function checkPkgName(string $pkgName): bool{

        if (empty($pkgName))
            return false;

        $pkgNameString = $this->getPropertySchema('name');

        if (empty($pkgNameString) || ($pkgNameString != $pkgName))
            return false;

    }


    /**
     * Method canRead
     *
     * @return bool
     */
    public function canRead():bool
    {
        if (is_file($this->fileName) && is_readable($this->fileName)) {
            return true;
            //throw new \Exception("Error '{self::$_fileName}' no es un archivo valido.");
        } else {
          //  if (false !== is_readable(self::$_fileName)) {
              //  throw new \Exception("Error '{self::$_fileName}' sin permiso de lectura.");
            //} else {
                return false;
          //  }
        }
        
    }
      
    /**
     * Method readFile
     *
     * @return self
     */
    public function readFile()
    {
        if (!$this->canRead()) {
            throw new \Exception("Error ". $this->fileName ." problema lectura.");
        } else {
            self::$_fileContent = file_get_contents($this->fileName);
        }
    
    }

    /**
     * Method getJson
     * Obtiene el contenido del archivo composer.json y retorna el SCHEMA en un array
     * asocitivo
     * 
     * @return array
     */

    public function getJson(): void
    {

        try {
            $this->jsonSchema = json_decode(self::$_fileContent, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            $e->getMessage(); // like json_last_error_msg()
            $e->getCode(); // like json_last_error()
        }

    }

    /**
     * Method getPropertySchema
     *
     * @param array $jsonSchema array asociativo con la estrucra del SCHEMA
     * @param string $propertyName nombre de la propiedad o grupo de elementos a extraer
     *
     * @return array
     */
    public function getPropertySchema(string $propertyName)
    {
        if (isset($this->jsonSchema[$propertyName])) {
            return $this->jsonSchema[$propertyName];
        } else {
            throw new \InvalidArgumentException('NE Propiedad SCHEMA '.$propertyName);
        }

    }

    public function getTreePkgSchema(string $masterRepository): array
    {
        $treeRepositoryArray = array();

        

        $requireArray = $this->getPropertySchema('require');

        $pkgNameString = $this->getPropertySchema('name');

        $pkgTypeString = $this->getPropertySchema('type');


        foreach ($requireArray as $pkgNameString => $pkgVersionString) {

            list($vendorNameString,$projectNameString) = array_pad(explode('/', $pkgNameString), 2, null);
        
            if ($masterRepository === $vendorNameString) {
                $treeRepositoryArray[$projectNameString] = array(
                    "type" => $pkgTypeString,
                    "name" => $vendorNameString,
                    "version" => $pkgVersionString);
            }
        }

        return $treeRepositoryArray;

    } // End method getTreePkgSchema

}

$file = '../../../Proyecto1/composer.json';
//$file = '../../../libreria1/composer.json';

$masterRepository = 'fabiosan75'; // Vendor Name directorio que contiene el repositorio

//$composerMeta = array();

$composerReader = new ComposerReader($file);
var_dump($composerReader);
$composerReader->readFile();
$composerReader->getJson(); 

$treePkgArray = $composerReader->getTreePkgSchema($masterRepository);

print_r($treePkgArray);


?>