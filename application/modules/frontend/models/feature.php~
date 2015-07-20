<?php
namespace frontend\models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tbl_feature")
 */
class feature
{
	
/**
* @ORM\Column(type="integer")
* @ORM\Id
* @ORM\GeneratedValue
*/
private $id;

/**
* @ORM\ManyToOne(targetEntity="frontend\models\product",inversedBy="features")
*/
private $product;

/**
* @ORM\Column(type="string")
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
     * Set product
     *
     * @param \frontend\models\product $product
     * @return feature
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

    /**
     * Set name
     *
     * @param string $name
     * @return feature
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
