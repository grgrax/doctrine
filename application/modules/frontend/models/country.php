<?php

namespace frontend\models;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="tbl_countries")
*/
class country 
{
	
/**
* @ORM\Column(type="integer")
* @ORM\Id
* @ORM\GeneratedValue
*/
private $id;

/**
* @ORM\Column(type="string",nullable=false)
*/
private $name;


    /**
     * Get id
     *
     * @return \intger 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return country
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
}
