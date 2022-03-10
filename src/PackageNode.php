<?php

namespace GetTreeRepository;

class PackageNode
{

    private $idNode;

    private $idPackage;

    private $name;

    private $vendor;

    private $version;

    private $source;

    private $type;

    private $license;

    private $authors;

    private $attributes = array();

    private $repositories = array();

    private $require = array();

    public function __construct()
    {
        $this->property = $property;
    }

   

    /**
     * Get the value of idNode
     */ 
    public function getIdNode()
    {
        return $this->idNode;
    }

    /**
     * Set the value of idNode
     *
     * @return  self
     */ 
    public function setIdNode($idNode)
    {
        $this->idNode = $idNode;

    }

    /**
     * Get the value of idPackage
     */ 
    public function getIdPackage()
    {
        return $this->idPackage;
    }

    /**
     * Set the value of idPackage
     *
     * @return  self
     */ 
    public function setIdPackage($idPackage)
    {
        $this->idPackage = $idPackage;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get the value of vendor
     */ 
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * Set the value of vendor
     *
     * @return  self
     */ 
    public function setVendor($vendor)
    {
        $this->vendor = $vendor;
    }

    /**
     * Get the value of version
     */ 
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set the value of version
     *
     * @return  self
     */ 
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * Get the value of source
     */ 
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set the value of source
     *
     * @return  self
     */ 
    public function setSource($source)
    {
        $this->source = $source;
    }

    /**
     * Get the value of type
     */ 
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @return  self
     */ 
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get the value of license
     */ 
    public function getLicense()
    {
        return $this->license;
    }

    /**
     * Set the value of license
     *
     * @return  self
     */ 
    public function setLicense($license)
    {
        $this->license = $license;
    }

    /**
     * Get the value of authors
     */ 
    public function getAuthors()
    {
        return $this->authors;
    }

    /**
     * Set the value of authors
     *
     * @return  self
     */ 
    public function setAuthors($authors)
    {
        $this->authors = $authors;
    }

    /**
     * Get the value of attributes
     */ 
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Set the value of attributes
     *
     * @return  self
     */ 
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Get the value of repositories
     */ 
    public function getRepositories()
    {
        return $this->repositories;
    }

    /**
     * Set the value of repositories
     *
     * @return  self
     */ 
    public function setRepositories($repositories)
    {
        $this->repositories = $repositories;
    }

    /**
     * Get the value of require
     */ 
    public function getRequire()
    {
        return $this->require;
    }

    /**
     * Set the value of require
     *
     * @return  self
     */ 
    public function setRequire($require)
    {
        $this->require = $require;
    }
}
