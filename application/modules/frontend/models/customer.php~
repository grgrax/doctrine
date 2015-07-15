<?php

namespace frontend\models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tbl_customers")
 */

class customer
{
    /**
     * @var integer
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string",nullable=false,unique=true)
     */
    private $name;

    /**
    * @ORM\OneToOne(targetEntity="frontend\models\cart",mappedBy="customer")
    */
    private $cart;


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
     * @return customer
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
     * Set cart
     *
     * @param \frontend\models\cart $cart
     * @return customer
     */
    public function setCart(\frontend\models\cart $cart)
    {
        $this->cart = $cart;

        return $this;
    }

    /**
     * Get cart
     *
     * @return \frontend\models\cart 
     */
    public function getCart()
    {
        return $this->cart;
    }
}
