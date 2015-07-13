<?php

namespace frontend\models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tbl_carts")
 */

class cart
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
    private $cart_number;

    /**
    * @ORM\OneToOne(targetEntity="frontend\models\customer",inversedBy="cart")
    */
    private $customer;



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
     * Set cart_number
     *
     * @param string $cartNumber
     * @return cart
     */
    public function setCartNumber($cartNumber)
    {
        $this->cart_number = $cartNumber;

        return $this;
    }

    /**
     * Get cart_number
     *
     * @return string 
     */
    public function getCartNumber()
    {
        return $this->cart_number;
    }

    /**
     * Set customer
     *
     * @param \frontend\models\customer $customer
     * @return cart
     */
    public function setCustomer(\frontend\models\customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \frontend\models\customer 
     */
    public function getCustomer()
    {
        return $this->customer;
    }
}
