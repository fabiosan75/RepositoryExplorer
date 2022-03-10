<?php

namespace GetTreeRepository;

use GetTreeRepository\Interfaces\ComposerReaderInterface;

class PackageNode
{

    private $_idNode;

    private $_idPackage;

    private $_name;

    private $_vendor;

    private $_version;

    private $_source;

    private $_type;

    private $_license;

    private $_authors;

    private $_attributes = array();

    private $_repositories = array();

    private $_require = array();

    public $composerReaderI;

    public function __construct(ComposerReaderInterface $composerReader)
    {
        $this->composerReaderI = $composerReader;
    }


    /**
     * Get the value of _idNode
     */ 
    public function get_idNode()
    {
        return $this->_idNode;
    }

    /**
     * Set the value of _idNode
     *
     * @return self
     */ 
    public function set_idNode($idNode)
    {
        $this->_idNode = $idNode;

    }

    /**
     * Get the value of _idPackage
     */ 
    public function get_idPackage()
    {
        return $this->_idPackage;
    }

    /**
     * Set the value of _idPackage
     *
     * @return self
     */ 
    public function set_idPackage($idPackage)
    {
        $this->_idPackage = $idPackage;
    }

    /**
     * Get the value of _name
     */ 
    public function get_name()
    {
        return $this->_name;
    }

    /**
     * Set the value of _name
     *
     * @return self
     */ 
    public function set_name($name)
    {
        $this->_name = $name;
    }

    /**
     * Get the value of _vendor
     */ 
    public function get_vendor()
    {
        return $this->_vendor;
    }

    /**
     * Set the value of _vendor
     *
     * @return self
     */ 
    public function set_vendor($vendor)
    {
        $this->_vendor = $vendor;
    }

    /**
     * Get the value of _version
     */ 
    public function get_version()
    {
        return $this->_version;
    }

    
    /**
     * Method setVersion
     *
     * @param $version 
     *
     * @return void
     */
    public function set_version($version)
    {
        $this->_version = $version;
    }

    /**
     * Get the value of _source
     */ 
    public function get_source()
    {
        return $this->_source;
    }

    /**
     * Set the value of _source
     *
     * @return self
     */ 
    public function set_source($source)
    {
        $this->_source = $source;
    }

    /**
     * Get the value of _type
     */ 
    public function get_Type()
    {
        return $this->_type;
    }

    /**
     * Set the value of _type
     *
     */ 
    public function set_Type($type)
    {
        $this->_type = $type;
    }

    /**
     * Get the value of _license
     */ 
    public function get_License()
    {
        return $this->_license;
    }

    /**
     * Set the value of _license
     *
     * @return self
     */ 
    public function set_License($license)
    {
        $this->_license = $license;
    }

    /**
     * Get the value of _authors
     */ 
    public function get_Authors()
    {
        return $this->_authors;
    }

    /**
     * Set the value of _authors
     *
     * @return self
     */ 
    public function set_Authors($authors)
    {
        $this->_authors = $authors;
    }

    /**
     * Get the value of _attributes
     */ 
    public function get_attributes()
    {
        return $this->_attributes;
    }

    /**
     * Set the value of _attributes
     *
     * @return self
     */ 
    public function set_attributes($attributes)
    {
        $this->_attributes = $attributes;
    }

    /**
     * Get the value of _repositories
     */ 
    public function get_Repositories()
    {
        return $this->_repositories;
    }

    /**
     * Set the value of _repositories
     *
     * @return self
     */ 
    public function set_Repositories($repositories)
    {
        $this->_repositories = $repositories;
    }
     
    /**
     * Method getRequire
     *
     * @return void
     */
    public function get_Require()
    {
        return $this->_require;
    }

    /**
     * Set the value of _require
     */ 
    public function set_Require($require)
    {
        $this->_require = $require;
    }

    public function setProperties(array $attrNames = array('name','license','type'))
    {

        foreach ( $attrNames as $key => $attrName) {

            if ($this->composerReaderI->hasAttribute($attrName)) {
                $methodName = 'set_'.$attrName;
                $value = $this->composerReaderI->getAttribute($attrName);
                $this->$methodName($value);
            }        
        }

        $this->set_attributes($this->composerReaderI->config);
    }

}
