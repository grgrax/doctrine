<?php

namespace frontend\models;

use Doctrine\ORM\Mapping as ORM;
/**
* @ORM\Entity
* @ORM\Table(name="tbl_phoneno")
*/
class phoneno
{
	
/**
* @ORM\Column(type="integer")
* @ORM\Id
* @ORM\GeneratedValue
*/	
private $id;

/**
* @ORM\Column(type="string")
*/	
private $number;


    /**
     * Set number
     *
     * @param string $number
     * @return phoneno
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string 
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Get id
     *
     * @return string 
     */
    public function getId()
    {
        return $this->id;
    }
}
