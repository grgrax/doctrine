<?php

namespace frontend\models;

use Doctrine\ORM\Mapping as ORM;



/**
 * @ORM\Entity
 * @ORM\Table(name="tbl_clients")
 */

class client
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
    * @ORM\ManyToOne(targetEntity="frontend\models\country")
    * @ORM\JoinColumn(nullable=false)
    */
    private $country;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return client
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

    /**
     * Set country
     *
     * @param \frontend\models\country $country
     * @return client
     */
    public function setCountry(\frontend\models\country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \frontend\models\country 
     */
    public function getCountry()
    {
        return $this->country;
    }
}
