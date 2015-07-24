<?php

namespace frontend\models;

use Doctrine\ORM\Mapping as ORM;



/**
 * @ORM\Entity
 * @ORM\Table(name="tbl_categories")
 */

class category
{
	/**
	* @ORM\Column(type="integer")
	* @ORM\Id
	* @ORM\GeneratedValue
	*/
	private $id;

	/**
	* @ORM\OneToMany(targetEntity="frontend\models\category",mappedBy="parent")
	* @ORM\JoinColumn(nullable=false)
	*/
	private $childs;


	/**
	* @ORM\ManyToOne(targetEntity="frontend\models\category",inversedBy="childs")
	* @ORM\JoinColumn(nullable=true)
	*/
	private $parent;

	/**
	* @ORM\Column(type="string",nullable=false)
	*/
	private $name;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->childs = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * @return category
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
     * Add childs
     *
     * @param \frontend\models\category $childs
     * @return category
     */
    public function addChild(\frontend\models\category $childs)
    {
        $this->childs[] = $childs;

        return $this;
    }

    /**
     * Remove childs
     *
     * @param \frontend\models\category $childs
     */
    public function removeChild(\frontend\models\category $childs)
    {
        $this->childs->removeElement($childs);
    }

    /**
     * Get childs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChilds()
    {
        return $this->childs;
    }

    /**
     * Set parent
     *
     * @param \frontend\models\category $parent
     * @return category
     */
    public function setParent(\frontend\models\category $parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \frontend\models\category 
     */
    public function getParent()
    {
        return $this->parent;
    }
}
