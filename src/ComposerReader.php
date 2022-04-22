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
    /**
     * Composer Schema
     *
     * @var array<string, array<string, string>|string>
     */
    public static array $dataSchema = [];

    public JsonDecoder $jsonDecoder;

    /**
     *  Atributos Schema
     *
     * @var array<string, array<string, string>|string>
     */
    public array $config = [];

    /**
     * Method __construct
     *
     * @param FileReaderInterface $reader instancia
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
     * @param JsonDecoderInterface $jsonDecoder Instancia
     *
     * @return void
     */
    public function loadConfig(JsonDecoderInterface $jsonDecoder)
    {
        self::$dataSchema = $jsonDecoder->loadSchema();

        try {
            if (!empty(self::$dataSchema)) {
                //  $jsonDecoder->fileReader::$fileName;
                foreach (self::$dataSchema as $key => $value) {
                    $this->config[$key] = $value;
                }
            } else {
                throw new ComposerException(
                    " SCHEMA Vacio :"
                    . $jsonDecoder->getReader()->getFileName()
                );
            }
        } catch (ComposerException $e) {
            $e->jsonError();
            die();
        }
    }

    /**
     * getConfig
     *
     * @return array<string, array<string, string>|string>
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * Method getSchema Retorna el array con el SCHEMA completo del composer.json
     *
     * @return array<string, array<string, string>|string>
     */
    public function getSchema(): array
    {
        return self::$dataSchema;
    }

    /**
     * Method hasAttribute  Verifica si Atributo/propiedad existe
     *                      en el composer->config Ej : name/version/require
     *
     * @param string $attrName Nombre del Atributo/propiedad
     *
     * @return bool
     */
    public function hasAttribute(string $attrName): bool
    {
        return isset($this->config[$attrName]);
    }

    /**
     * Method getAttribute Devuelve un atributo del SCHEMA
     *
     * @param string $attrName Nombre del Atributo/propiedad del SCHEMA
     *
     * @return string
     */
    public function getAttribute(string $attrName): string
    {
        try {
            if ($this->hasAttribute($attrName)) {
                $attrValue = is_array($this->config[$attrName]) ?
                    '' : $this->config[$attrName];
                return $attrValue;
            } else {
                throw new ComposerException("NE Propiedad '{$attrName}' en SCHEMA ");
            }
        } catch (ComposerException $e) {
            $e->jsonError();
            die();
        }
    }

    /**
     * Method getAttrArray Extrae del SCHEMA una propiedad de tipo array
     *                      Ej : require, repositories
     *
     * @param string $attrName Nombre de la propiedad o atributo del SCHEMA
     *
     * @return array<string, array<string, string>>|array<string, string>
     *
     */
    public function getAttrArray(string $attrName): array
    {
        $attrValue = [];
        if (
            array_key_exists($attrName, $this->config)
            && is_array($this->config[$attrName])
            && count($this->config[$attrName])
        ) {
            $attrValue = $this->config[$attrName];
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
