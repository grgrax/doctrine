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
* @ORM\ManyToOne(targetEntity="frontend\models\eproduct",inversedBy="features")
* @ORM\JoinColumn(nullable=false)
*/
private $eproduct;

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



  
    /**
     * Set eproduct
     *
     * @param \frontend\models\eproduct $eproduct
     * @return feature
     */
    public function setEproduct(\frontend\models\eproduct $eproduct)
    {
        $this->eproduct = $eproduct;

        return $this;
    }

    /**
     * Get eproduct
     *
     * @return \frontend\models\eproduct 
     */
    public function getEproduct()
    {
        return $this->eproduct;
    }
}
