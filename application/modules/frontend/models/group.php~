<?php
namespace frontend\models;
use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="tbl_groups")
*/
class group 
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
    * @ORM\ManyToMany(targetEntity="frontend\models\permission",inversedBy="group")
    * @ORM\JoinTable(name="tbl_groups_permissions")
    */
    private $permissions;

    public function __construct()
    {
        $this->permissons = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return group
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

    public function resetPermissons()
    {
        $this->permissions = new \Doctrine\Common\Collections\ArrayCollection;
    }

    /**
     * Add permissions
     *
     * @param \frontend\models\permission $permissions
     * @return group
     */
    public function addPermission(\frontend\models\permission $permissions)
    {
        $this->permissions[] = $permissions;

        return $this;
    }

    /**
     * Remove permissions
     *
     * @param \frontend\models\permission $permissions
     */
    public function removePermission(\frontend\models\permission $permissions)
    {
        $this->permissions->removeElement($permissions);
    }

    /**
     * Get permissions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPermissions()
    {
        return $this->permissions;
    }
}
