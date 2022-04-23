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

use RepositoryExplorer\Interfaces\ComposerReaderInterface;

/**
 * Class PackageNode : Implementa los metodos para crear un objeto Package
 *                     con todas los atributos/propiedades del composer SCHEMA
 *
 * @category Class
 * @package  RepositoryExplorer
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 */
class PackageNode
{
    // const URL_BASE_REPOSITORY = 'https://github.com/';
    private const TYPE_REPOSITORY = 'vcs';

    /**
     * @var array<int, string> $repoHost
     *
     * Host validos repositorios Basado en los metodos
     *               implementados en el paquete de Composer
     *   URL : https://fossies.org/linux/www/legacy/composer-2.2.6.tar.gz/composer-2.2.6/src/Composer/Util/Url.php
     */

    public static array $repoHost = array('api.github.com','github.com',
                              'www.github.com','gitlab.com','www.gitlab.com',
                              'bitbucket.org','www.bitbucket.org');

    /**
     * Array configAttrArray Lista de atributos a ser "seteados" dinamicamente
     *                  como propiedades de la clase con el metodo setProperties()
     *                  del json SCHEMA a el componente del paquene PackageNode
     *                  EJ : 'name','license','type' estas propiedades NO deben
     *                  ser del tipo array como (require/repositories etc).
     *
     * @var array<int, string> $configAttrArray
     */
    private static array $configAttrArray = array('name','description',
                                    'version',
                                    'license','type');

    public static int $idNode;
    public static string $idPackage;
    protected string $name; // <vendor>/<name>
    protected string $shortName; // <name>
    protected string $vendor; // <vendor>
    protected string $version;
    protected string $source;
    protected string $type;
    protected string $description;
    protected string $license;
    /**
     * @var array<string, array<string, string>>
     */
    protected array $authors;
    /**
     * @var array<string, string>
     */
    protected array $attributes;
    /**
     * @var array<string, array<string, string>>
     */
    protected array $repositories;
    /**
     * @var array<string, array<string, string>>
     */
    protected array $require;

    public static ComposerReaderInterface $reader;

    /**
     * Method __construct
     *
     * @param ComposerReaderInterface $reader CRI
     *
     * @return void
     */
    public function __construct(ComposerReaderInterface $reader)
    {
        self::$reader = $reader;
        $this->loadConfig();
    }

    /**
     * Method loadConfig
     *
     * @return void
     */
    public function loadConfig(): void
    {
        $pkgName = self::$reader->getAttribute('name');

        list($vendor,$shortName) = array_pad(explode('/', $pkgName), 2, null);

        $this->setType(self::$reader->getAttribute('type'));
        $this->setName($pkgName);  // <vendor>/<name>
        $this->setVendor($vendor); // <vendor>
        $this->setShortName($shortName); // <name>
        $this->setProperties(self::$configAttrArray);
        $this->setAttributes(self::$reader->getConfig());
        $this->setAuthors(self::$reader->getAttrArray('authors'));

        $arrayRepositories = $this->setUpRepositories(
            $vendor,
            self::$reader->getAttrArray('repositories')
        );

        $this->setRepositories($arrayRepositories);

        $arrayRequire =  $this->setUpRequire(
            self::$reader->getAttrArray('require'),
            $arrayRepositories
        );

        $this->setRequire($arrayRequire);
    }

    /**
     * Method getIdNode
     *
     * @return int
     */
    public function getIdNode(): int
    {
        return $this->idNode;
    }

    /**
     * Method setIdNode
     *
     * @param int $idNode idNode
     *
     * @return void
     */
    public function setIdNode(int $idNode)
    {
        $this->idNode = $idNode;
    }

    /**
     * Method getIdPackage
     *
     * @return string
     */
    public function getIdPackage(): string
    {
        return $this->idPackage;
    }


    /**
     * Method setIdPackage
     *
     * @param string $idPackage packageName
     *
     * @return void
     */
    public function setIdPackage(string $idPackage)
    {
        $this->idPackage = $idPackage;
    }

    /**
     * Method getName
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Method setName
     *
     * @param string $name name
     *
     * @return void
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }


    /**
     * Method getShortName
     *
     * @return string
     */
    public function getShortName(): string
    {
        return $this->shortName;
    }

    /**
     * Method setShortName
     *
     * @param string $shortName Shortname
     *
     * @return void
     */
    public function setShortName(string $shortName)
    {
        $this->shortName = $shortName;
    }

    /**
     * Method getVendor
     *
     * @return string
     */
    public function getVendor(): string
    {
        return $this->vendor;
    }

    /**
     * Method setVendor
     *
     * @param string $vendor vendor
     *
     * @return void
     */
    public function setVendor(string $vendor)
    {
        $this->vendor = $vendor;
    }

    /**
     * Method getVersion
     *
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * Method setVersion
     *
     * @param string $version version
     *
     * @return void
     */
    public function setVersion(string $version)
    {
        $this->version = $version;
    }

    /**
     * Method getSource
     *
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * Method setSource
     *
     * @param string $source src
     *
     * @return void
     */
    public function setSource(string $source)
    {
        $this->source = $source;
    }

    /**
     * Method getType
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Method setType
     *
     * @param string $type type
     *
     * @return void
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * Method getDescription
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Method setDescription
     *
     * @param string $description description
     *
     * @return void
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * Method getLicense
     *
     * @return string
     */
    public function getLicense(): string
    {
        return $this->license;
    }

    /**
     * Method setLicense
     *
     * @param string $license license
     *
     * @return void
     */
    public function setLicense(string $license)
    {
        $this->license = $license;
    }

    /**
     * Method getAuthors
     *
     * @return array<string, array<string, string>>
     */
    public function getAuthors(): array
    {
        return $this->authors;
    }

    /**
     * Method setAuthors
     *
     * @param array<string, array<string, string>> $authors authors
     *
     * @return void
     */
    public function setAuthors(array $authors)
    {
        $this->authors = $authors;
    }


    /**
     * Method getAttributes
     *
     * @return array<string, string>
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * Method setAttributes
     *
     * @param array<string, string> $attributes attr
     *
     * @return void
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Method getRepositories
     *
     * @return array<string, array<string, string>>
     */
    public function getRepositories(): array
    {
        return $this->repositories;
    }

    /**
     * Method setRepositories
     *
     * @param array<string, array<string, string>> $repositories Atributo/propiedad
     *                                             <repositories> en composer.json
     *
     * @return void
     */
    public function setRepositories(array $repositories)
    {
        $this->repositories = $repositories;
    }

    /**
     * Method getRequire
     *
     * @return array<string, array<string, string>>
     */
    public function getRequire(): array
    {
        return $this->require;
    }


    /**
     * Method setRequire
     *
     * @param array<string, array<string, string>> $require Atributo/propiedad <require>
     *                                       en composer.json
     *
     * @return void
     */
    public function setRequire(array $require)
    {
        $this->require = $require;
    }

    /**
     * Method setProperties Implementa el metodo para "setear" dinamicamente
     *                  la Lista de atributos $configAttrArray como propiedades
     *                  de la clase
     *
     * @param array<int, string> $attrNames Atributos del SCHEMA
     *                                         Ej: 'name','license','type'
     *
     * @return void
     */
    public function setProperties(
        array $attrNames = array('name','license','type')
    ): void {

        foreach ($attrNames as $attrName) {
            if (self::$reader->hasAttribute($attrName)) {
                $methodName = 'set' . ucfirst($attrName);
                $value = self::$reader->getAttribute($attrName);
                self::$methodName($value);
            }
        }
    }

    /**
     * Method setUpRepositories
     *
     * @param string                $vendorName   VendorName de paquete a filtrar
     *                                            Para agreagr solo del mismo Vendor
     * @param array<string, array<string, string>> $repositories jsonSchema(S)
     *
     * @return array<string, array<string, string>>
     */
    public function setUpRepositories(string $vendorName, array $repositories): array
    {
        $pckRepositories = [];

        foreach ($repositories as $repository) {
            if (is_array($repository) && !array_key_exists('url', $repository)) {
                continue;
            }

            //$host = array_key_exists('url', $repository) ? parse_url($repository['url'], PHP_URL_HOST) : '';
            $host = parse_url($repository['url'], PHP_URL_HOST);

            //  echo in_array($host, self::$repoHost)?'EN ARRAY':'NO EN ARRA';
            if (
                !in_array($host, self::$repoHost)
                || !is_array($repository)
                || !array_key_exists('type', $repository)
            ) {
                continue;
            }

            $pkgName = ltrim(parse_url($repository['url'], PHP_URL_PATH), '/');

             // Explode Package name (<vendor>/<name>)
            list($vendorPck,$repoName) = array_pad(explode('/', $pkgName), 2, null);

            if (
                $vendorName === $vendorPck
                && ($repository['type'] === self::TYPE_REPOSITORY)
            ) {
                $pckRepositories[$pkgName] = array(
                    "type" => $repository['type'],
                    "vendor" => $vendorPck,
                    "url" => $repository['url']
                );
            }
        }
        return $pckRepositories;
    }

    /**
     * Method setUpRequire Crea un array con las dependiencias del paquete
     *                     para ser "seteadas" en el objeto packageNode
     *
     * @param array<string, array<string, string>> $requireArray Arreglo con los dependencias encontrados en el
     *                            composer.json propiedad <require>
     * @param array<string, array<string, string>> $repositories Arreglo con los repositorios encontrados en el
     *                            composer.json <repositories> para validar que
     *                            la dependencia esta incluida en los repositorios
     *                            definidos para el paquete/proyecto
     *
     * @return array<string, array<string, array<string, string>|string>>
     */
    public function setUpRequire(array $requireArray, array $repositories): array
    {
        $pckRequire = [];

        foreach ($requireArray as $pckName => $pckVersion) {
            // si el paquete/libreria noexiste en repositories
            if (array_key_exists($pckName, $repositories)) {
                $pckRequire[$pckName] = array(
                                        "name" => $pckName,
                                        "version" => $pckVersion,
                                        "url" => $repositories[$pckName]['url']
                                    );
            }
        }

        return $pckRequire;
    }
}
