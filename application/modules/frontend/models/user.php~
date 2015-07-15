<?php
namespace frontend\models;
use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="tbl_users")
*/
class user 
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
private $username;

/**
* @ORM\ManyToMany(targetEntity="frontend\models\phoneno")
* @ORM\JoinTable(name="user_phonenos",joinColumns={@ORM\JoinColumn(name="user_id",referencedColumnName="id")},inverseJoinColumns={@ORM\JoinColumn(name="phoneno_id",referencedColumnName="id",unique=true)})
*/

private $phonenos;


public function __construct()
{
    $this->phonenos = new \Doctrine\Common\Collections\ArrayCollection();
}
    /**
     * Set id
     *
     * @param integer $id
     * @return user
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * Set username
     *
     * @param string $username
     * @return user
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Add phonenos
     *
     * @param \frontend\models\phoneno $phonenos
     * @return user
     */
    public function addPhoneno(\frontend\models\phoneno $phonenos)
    {
        $this->phonenos[] = $phonenos;

        return $this;
    }

    /**
     * Remove phonenos
     *
     * @param \frontend\models\phoneno $phonenos
     */
    public function removePhoneno(\frontend\models\phoneno $phonenos)
    {
        $this->phonenos->removeElement($phonenos);
    }

    /**
     * Get phonenos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPhonenos()
    {
        return $this->phonenos;
    }
}
