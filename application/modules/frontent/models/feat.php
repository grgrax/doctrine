<?php

namespace frontent\models;

use Doctrine\ORM\Mapping as ORM;

/**
 * feat
 */
class feat
{
    /**
     * @var intger
     */
    private $id;

    /**
     * @var \frontend\models\product
     */
    private $product;


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
     * Set product
     *
     * @param \frontend\models\product $product
     * @return feat
     */
    public function setProduct(\frontend\models\product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \frontend\models\product 
     */
    public function getProduct()
    {
        return $this->product;
    }
}
